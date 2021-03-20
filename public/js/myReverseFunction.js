function getListIdx(str, substr) {
    let listIdx = [];
    let lastIndex = -1;
    while ((lastIndex = str.indexOf(substr, lastIndex + 1)) !== -1) {
        listIdx.push(lastIndex);
    }
    return listIdx;
}
// на вход получает постфиксную обратную польскую запись
// на выходе та же запись, но с инверсированным порядком чисел
function reverseNumbers(str)
{
    // удалим все пробелы
    str = str.replace(/\s+/, '');

    // После каждого числа или оператора добавляем разделитель ';'
    str = str.replace(/([0-9]+[.][0-9]+)|([0-9]+)|(x)|(\+)|(-)|(\/)|(\*)/g,"$&;");

    // разделим строку по разделителю ';'
    let arr = str.split(';');

    // удалим последний элемент массива -- пустую строку после последнего рзделителя
    arr.pop();
    console.log("arr:", arr);



    // alert("1");
    // numberPositions.reverse();
    // console.log("reversed number positions:", numberPositions);
}
