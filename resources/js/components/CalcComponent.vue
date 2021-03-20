<template>
    <div>
        <div class="dropdown">
            <button type="button" class="btn btn-lg btn-dark dropdown-toggle" data-toggle="dropdown">
                {{ calculators[index].name }}
            </button>
            <div class="dropdown-menu">
                <a v-for="(calc, i) in calculators" @click="selectCalculator(i)" class="dropdown-item"
                   href="#">{{ calc.name }}</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col" v-for="(column, columnIndex) in columns">
                <label>Введите значение:</label>
                <small v-if="columns[columnIndex].inputError!==''" class="text-danger">
                    {{ columns[columnIndex].inputError }}
                </small>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{ units[column.selectedUnitIndex].symbol }}</span>
                    </div>
                    <input v-model="columns[columnIndex].value" @input="convertFromThisColumn(columnIndex)" type="text"
                           class="form-control" :class="{'is-invalid':columns[columnIndex].inputError !== ''}"
                           aria-describedby="basic-addon3">
                    <div class="input-group-append">
                        <span
                            class="input-group-text">{{ columns[columnIndex].value10.part1 }}.{{ columns[columnIndex].value10.part2 }}&times;10<sup>{{ columns[columnIndex].value10.stepen10 }}</sup></span>
                    </div>
                </div>


                <ul class="list-group">
                    <li v-for="(unit, unitRowIndex) in units" @click="selectUnit(unitRowIndex, columnIndex)"
                        class="list-group-item"
                        :class="{'active':columns[columnIndex].selectedUnitIndex === unitRowIndex}">
                        <div class="float-left">{{ unit.symbol }}</div>
                        <div class="float-right">{{ unit.name }}</div>
                    </li>
                </ul>

            </div>
        </div>

    </div>
</template>
<script>

export default {
    props: ['calculators'],
    data: function () {
        return {
            index: 0, // текущий выбранный элемент выпадающего списка
            units: this.calculators[0].units, // юниты (единицы измерения) текущего выбранного калькулятора
            columns: [ // сколько объектов в этом массиве, столько и списков будет создано. в каждом списке по умолчанию выбраны самые первые юниты
                {selectedUnitIndex: 0, value: 1.0, value10: {part1: 1, part2: 0, stepen10: 0}, inputError: ''},
                {selectedUnitIndex: 0, value: 1.0, value10: {part1: 1, part2: 0, stepen10: 0}, inputError: ''}
            ],
            calc: {},


        }
    },
    methods: {
        // Выбор калькулятора из выпадающего списка по индексу i
        selectCalculator(i) {
            // при переключении калькулятора будут 2 столбца, в котором будут выбраны первые строки
            this.columns = [
                {selectedUnitIndex: 0, value: 1.0, value10: {part1: 1, part2: 0, stepen10: 0}, inputError: ''},
                {selectedUnitIndex: 0, value: 1.0, value10: {part1: 1, part2: 0, stepen10: 0}, inputError: ''}
            ];
            // обновляем текущий индекс выпадающего списка
            this.index = i;

            // обновляем список текущих единиц измерения
            this.units = this.calculators[i].units;

            // пробежимся по юнитам и приведём funcToSI и funcFromSI к виду функций JS
            for (let i = 0; i < this.units.length; i++) {
                //TODO: убрать это
                console.log(infixToPostfix(this.units[i].funcToSI));
                this.units[i].funcToSI = new Function("x", "return parseFloat(" + this.units[i].funcToSI + ");");

                this.units[i].funcFromSI = new Function("x", "return parseFloat(" + this.units[i].funcFromSI + ");");
            }

            console.log('Переключил на: ' + this.calculators[i].name);
        },

        // Выбор юнита-строки unitRowIndex из столбца columnIndex
        selectUnit(unitRowIndex, columnIndex) {
            console.log('В столбце [' + columnIndex + '] выбрана строка [' + unitRowIndex + ']');

            // записываем активный юнит-строку столбца columnIndex
            this.columns[columnIndex].selectedUnitIndex = unitRowIndex;

            // вызываем конвертацию из другого столбца, но только не из этого
            let tempColumn = columnIndex === 0 ? 1 : 0; // если это 0 -- выбираем 1, а если это не 0, то выбираем 0
            this.convertFromThisColumn(tempColumn);

        },


        // если всё ок, то возвращается пустой inputError
        validateInput(value) {
            let inputError = '';
            // если содержатся какие-либо символы кроме цифр, минуса и точки
            if (value.toString().match(/[^0-9\.\-]+/))
                inputError = 'Недопустимый символ';

            // если в глобальном поиске точек найдётся больше двух
            let matches = value.toString().match(/\./g);
            if (matches !== null && matches.length > 1)
                inputError = 'Больше одной точки';

            // если минус и будет, то должен он быть только один раз
            matches = value.toString().match(/\-/g);
            if (matches !== null && matches.length > 1)
                inputError = 'Больше одного знака минус';

            if (matches !== null && value.toString().indexOf("-") !== 0)
                inputError = 'Знак минус находится не на своём месте';

            return inputError;
        },

        isNaN(value) {
            return value !== value;
        },

        // производит конвертацию величин. в качестве аргумента указывается столбец columnIndex, изменение которого инициирует конвертацию
        convertFromThisColumn(columnIndex) {
            // значение изменённого столбца
            let value = this.columns[columnIndex].value;

            if (this.isNaN(parseFloat(value))) {
                console.log('Предотвращение NaN 1');
                value = 0;
            }

            // ВАЛИДАЦИЯ
            this.columns[columnIndex].inputError = this.validateInput(value);

            // обновляем стандартный вид числа для столбца, в котором производились изменения
            this.columns[columnIndex].value10 = this.getValue10(value);

            // вытащим текущий активный юнит-строку столбца
            let unitRowIndex = this.columns[columnIndex].selectedUnitIndex;

            // определим функцию перевода в SI
            let convertToSI = this.units[unitRowIndex].funcToSI;

            // Переводим изменённое значение в SI:
            let valueSI = convertToSI(value);
            console.log('Получено значение в системе SI: ' + valueSI + ' ' + this.calculators[this.index].symbolSI);
            if (this.isNaN(valueSI)) {
                console.log('Предотвращение NaN 2');
                this.columns[columnIndex].value = 0;
            }

            // Пробежимся по всем столбцам кроме текущего и ПЕРЕВЕДЁМ funcFromSI
            for (let i = 0; i < this.columns.length; i++) {
                // текущий столбец не трогаем
                if (i === columnIndex) continue;

                // какая строка-юнит выбрана в текущем перебираемом столбце
                let selectedUnitIndex = this.columns[i].selectedUnitIndex;

                // вытащим из юнита, выбранного в этом столбце: функцию перевода funcFromSI
                let convertFromSI = this.units[selectedUnitIndex].funcFromSI;

                // переводим funcFromSI в текущую единицу измерения текущего столбца
                this.columns[i].value = convertFromSI(valueSI);

                // ---ДОПОЛНИТЕЛЬНО ПОСЛЕ КОНВЕРТАЦИИ---
                // обновляем стандартный вид числа для сконвентированного выражения
                this.columns[i].value10 = this.getValue10(this.columns[i].value);

                // когда JS будет переводить наши числа в свой e+21 формат -- мы будем переводить это число к обратному виду в форме строки
                if (this.columns[i].value10.stepen10 > 20 || this.columns[i].value10.stepen10 < -6)
                    this.columns[i].value = this.eNumberToNormalNumberLongString(this.columns[i].value);

            }
        },

        // переводит 0.0039 => 3.9 * 10 ^ -3
        getValue10(value) {
            let isNegative = false;
            if (value < 0) {
                isNegative = true;
                value = value * (-1);
            }
            // число знаков после запятой:
            let ostatokCount = 3;

            // текущее значение явно преобразуем в число
            value = parseFloat(value);

            // примерная структура результата
            let result = {
                part1: 3,
                part2: 9,
                stepen10: -3
            };

            // формирует результат, приводя число к виду трёх знаков после запятой
            function setResult(standartValue, stepen10) {
                // округляем до ostatokCount знаков после запятой
                standartValue = standartValue.toFixed(ostatokCount);

                // целая часть числа
                result.part1 = Math.trunc(standartValue);

                // преобразуем то, что после запятой: получим в текстовом виде c фиксом до ostatokCount знаков после запятой, без нулей в конце
                let ostatokString = (standartValue - result.part1).toFixed(ostatokCount) * 1;
                result.part2 = ostatokString.toString().replace(/0\./, ''); // убрали 0.

                // зададим степень десяти
                result.stepen10 = stepen10;

                // не забудем вернуть минус, если число было отрицательным
                if (isNegative) result.part1 *= (-1);
            }

            // число не нужно приводить к стандартному виду, только округлить
            if (value >= 1 && value < 10 || value === 0) {
                // число приводится к стандартному виду, а степень 10 устанавливается как 0
                setResult(value, 0);
                // console.log('standartValue: ' + value);
                return result;
            }
            // если значение меньше 1, значит нам нужно будет умножать на 10 пока значение на станет >= 1 и < 10
            if (value < 1) {
                // сняли копию
                let standartValue = value;
                let counter = 0;
                while (!(standartValue >= 1 && standartValue < 10)) {
                    counter++;
                    standartValue *= 10;
                    if (counter > 320) {
                        counter = ' < -320';
                        break;
                    }
                }
                console.log('standartValue: ' + standartValue);
                // число приводится к стандартному виду, а степень 10 устанавливается как counter
                setResult(standartValue, -counter);
                return result;
            }
            // если значение больше или равно 10, значит нам нужно будет делить на 10 пока значение на станет >= 1 и < 10
            if (value >= 10) {
                // сняли копию
                let standartValue = value;
                let counter = 0;
                while (!(standartValue >= 1 && standartValue < 10)) {
                    counter++;
                    standartValue /= 10;
                    if (counter > 300) {
                        // ЧИСЛО ПРИНИМАЕТ ВИД 9.99e+21
                        counter = ' > 300'
                        break;
                    }
                }
                console.log('standartValue: ' + standartValue);
                // число приводится к стандартному виду, а степень 10 устанавливается как counter
                setResult(standartValue, counter);
                return result;
            }
        },

        // переводит число 3.9e-7 в строку '0.00000039'. Это нужно для того, чтобы избавиться от тотбражения в виде 3.9e-7
        eNumberToNormalNumberLongString(value) {
            let resultString = '';
            let isNegative = (value < 0);
            value += '';

            // разобьем на две части: до e+ и после e+
            let numberEParts = [];
            if (value.match(/e\+/) !== null) numberEParts = value.split('e+');  // число с положительным порядком, например: '1.234e+21'
            if (value.match(/e-/) !== null) numberEParts = value.split('e-');  // число с положительным порядком, например: '1.234e-6'

            let number = numberEParts[0];
            if (isNegative) number = number.replace('-', '');

            let stepen10 = numberEParts[1];


            if (value.match(/e\+/) !== null) {
                resultString = number.replace('.', '');

                // узнаем n кол-во символов после запятой, чтобы потом убрать запятую и добавить в конец (stepen10 - n) нулей
                let lengthAfterComma = 0;
                if (number.match(/\./) !== null) lengthAfterComma = number.split(".")[1].length;
                // количество нулей, что нужно добавить к resultString
                let count0 = stepen10 - lengthAfterComma;
                for (let i = 0; i < count0; i++) resultString += '0';
            }


            // число с отрицательным порядком
            if (value.match(/e-/) !== null) {
                resultString = '0.';
                // количество нулей, что нужно добавить к resultString
                let count0 = stepen10 - 1;
                for (let i = 0; i < count0; i++) resultString += '0';
                resultString += number.replace('.', '');
            }
            // если число изначально было отрицательным, то добавляем минус
            if (isNegative) resultString = '-' + resultString;
            console.log('resultString: ' + resultString);
            return resultString;
        },



},
mounted()
{
    this.selectCalculator(this.index);

    // Хитро подключаем нашу бибилиотеку

    console.log(infixToPostfix("x ^ y / (5 * z) + 10"));


    // var script = document.createElement('script');
    // script.src = "/js/myLib.js";
    // document.getElementsByTagName('head')[0].appendChild(script);

    // let myLib = document.createElement('script');
    // document.head.appendChild(myLib);
    // myLib.helloWorld();


}

}
</script>
