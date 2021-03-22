// на вход получает тело функции в виде строки
// на выходе тело обратной функции
function getReverseFunctionString(str) {
    // переводим тело функции в обратную польскую запись
    str = infixToPostfix(str);
    console.log("обратная польская запись: ", str);


    // После каждого числа или оператора добавляем разделитель ';'
    str = str.replace(/([0-9]+[.][0-9]+)|([0-9]+)|(x)|(\+)|(-)|(\/)|(\*)|(\^)/g, "$&;");

    // разделим строку по разделителю ';'
    let arr = str.split(';');

    // удалим пробелы у каждого элемента массива
    arr.forEach(function (currentValue, index, arr) {
        arr[index] = arr[index].replace(/\s+/g, '');
    });

    // удалим последний элемент массива -- пустую строку после последнего рзделителя
    arr.pop();


    console.log("arr:", arr);

    // теперь нам нужно свапнуть числа и знаки местами
    function isNum(strValue) {
        return strValue.match(/([0-9]+[.][0-9]+)|([0-9]+)/) !== null;
    }

    function isOperator(strValue) {
        return strValue.match(/(\+)|(-)|(\/)|(\*)|(\^)/) !== null;
    }

    // соберем массивы из чисел и операторов
    let numbers = [];
    let operators = [];
    arr.forEach(function (currentValue, index, arr) {
        if (isNum(currentValue)) {
            numbers.push(currentValue);
        }
        if (isOperator(currentValue)) {
            operators.push(currentValue);
        }
    });
    // обратим эти массивы задом-наперёд
    numbers.reverse();
    operators.reverse();

    // вставим элементы обращенных массивов обратно в arr на свои места
    arr.forEach(function (currentValue, index, arr) {
        if (isNum(currentValue)) {
            arr[index] = numbers.shift();
        }
    });
    console.log("arr после реверса чисел:");
    console.log("arr:", arr);

    arr.forEach(function (currentValue, index, arr) {
        if (isOperator(currentValue)) {
            arr[index] = operators.shift();
        }
    });
    console.log("arr после реверса знаков:");
    console.log("arr:", arr);




    // заменим + на -, * на / и тд
    arr.forEach(function (currentValue, index, arr) {
        if (currentValue === "+") arr[index] = "-";
        if (currentValue === "-") arr[index] = "+";
        if (currentValue === "*") arr[index] = "/";
        if (currentValue === "/") arr[index] = "*";
    });

    console.log("arr после смены знаков на противополож:");
    console.log("arr:", arr);

    // склеивание c разделителем -- пробелом
    let reverseString = arr.join(' ');
    console.log("склейка в строку: ", reverseString);

    // переводим из польской обратно в обычную инфиксную запись
    return postfixToInfix(reverseString);
}
