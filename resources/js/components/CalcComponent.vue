<template>
    <div>
        <div class="dropdown">
            <button type="button" class="btn btn-lg btn-dark dropdown-toggle" data-toggle="dropdown">
                {{ calculators[index].name }}
            </button>
            <div class="dropdown-menu">
                <a v-for="(calc, i) in calculators" @click="selectCalculator(i)" class="dropdown-item"
                   href="#">{{ calc.name }}
                </a>
            </div>
        </div>
<!--        SI: "{{calculators[index].defaultUnitName}}" ({{calculators[index].defaultUnitSymbol}})-->
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
            <div class="col-1">
                <br>
                <button @click="addColumn()" type="button" class="btn btn-outline-success my-2">&#9658;</button>
                <br>
                <button @click="deleteColumn()" type="button" class="btn btn-outline-danger my-2">&#9668;</button>

            </div>
        </div>

    </div>
</template>
<script>

export default {
    // получаем из контроллера
    props: ['calculators'],
    // данные приложения, структуру которых определяем мы
    data: function () {
        return {
            // текущий выбранный элемент выпадающего списка
            index: 0,

            // [из json-файлов] юниты (единицы измерения) текущего выбранного калькулятора
            units: this.calculators[0].unitsOfMeasurement,

            // образец пустого столбца
            emptyColumn: {
                // выбранная строка, по умолчанию выбрана первая строка
                selectedUnitIndex: 0,
                // стартовое значение поля
                value: 1.0,
                // единица измерения в системе SI
                value10: {
                    part1: 1, // целая часть
                    part2: 0, // после запятой
                    stepen10: 0
                },
                // возникшая ошибка при вводе
                inputError: ''
            },

            // [для построения HTML-содержимого страницы] массив, в зависимости от которого происходит построение DOM столбцов
            // Изначально этот массив содержит два пустых столбца
            columns: [
                Object.assign({}, this.emptyColumn), // Object.assign(,) позволяет копировать объект вместе с его содержимым,
                Object.assign({}, this.emptyColumn), // а не просто получать ссылку на него. Используется дял получения независимых копий столбцов
            ],
        }
    },
    methods: {
        // добавление ещё одного столбца
        addColumn() {
            this.columns.push(Object.assign({}, this.emptyColumn));
            this.convertFromThisColumn(0);
        },

        // удаление столбца
        deleteColumn() {
            if (this.columns.length > 2)
            this.columns.pop();
        },

        // Выбор калькулятора из выпадающего списка по индексу i
        selectCalculator(index) {
            //if (this.index === i) return;

            // обновляем текущий индекс выпадающего списка
            this.index = index;

            // обновляем список текущих единиц измерения
            this.units = null;
            this.units = this.calculators[this.index].unitsOfMeasurement;

            // при переключении калькулятора будут 2 столбца, в котором будут выбраны первые строки
            this.columns = [
                Object.assign({}, this.emptyColumn),
                Object.assign({}, this.emptyColumn),
            ];

            // пробежимся по юнитам и сформируем тело обратным функциям
            for (let i = 0; i < this.units.length; i++) {
                if (this.units[i].defaultUnitFormula === "")
                    this.units[i].defaultUnitFormula = getReverseFunctionString(this.units[i].currentUnitFormula);
                if (this.units[i].currentUnitFormula === "")
                    this.units[i].currentUnitFormula = getReverseFunctionString(this.units[i].defaultUnitFormula);
            }
            console.log('Переключил на: ' + this.calculators[this.index].name);
        },

        // Выбор юнита-строки unitRowIndex из столбца columnIndex
        selectUnit(unitRowIndex, columnIndex) {
            console.log('В столбце [' + columnIndex + '] выбрана строка [' + unitRowIndex + ']');

            // текущий столбец запоминает строку(единицу измерения (юнит)), которая в нём выбрана
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

        // проверка на isNaN, для предоствращения жизненных трудностей
        isNaN(value) {
            return value !== value;
        },

        // производит конвертацию величин. в качестве аргумента указывается столбец columnIndex, изменение которого инициирует конвертацию
        convertFromThisColumn(columnIndex) {
            // значение изменённого столбца
            let value = this.columns[columnIndex].value;

            if (this.isNaN(parseFloat(value))) {
                console.log('Предотвращение NaN 1');
                value = 1;
            }

            // ВАЛИДАЦИЯ
            this.columns[columnIndex].inputError = this.validateInput(value);

            // обновляем стандартный вид числа для столбца, в котором производились изменения
            this.columns[columnIndex].value10 = this.getValue10(value);

            // вытащим текущий активный юнит-строку столбца
            let unitRowIndex = this.columns[columnIndex].selectedUnitIndex;

            // определим функцию перевода в единицу измерения по умолчанию
            let convertToDefault = new Function("x", "return parseFloat(" + this.units[unitRowIndex].defaultUnitFormula + ");");

            // Переводим изменённое значение ТЕКУЩЕГО СТОЛБЦА в ед. изм. по умолчанию:
            let defaultValue = convertToDefault(value);

            if (this.isNaN(defaultValue)) {
                console.log('Предотвращение NaN 2');
                this.columns[columnIndex].value = 1;
            }

            // Пробежимся по всем столбцам кроме текущего и ПЕРЕВЕДЁМ convertToCurrent
            for (let i = 0; i < this.columns.length; i++) {
                // текущий столбец не трогаем
                if (i === columnIndex) continue;

                // какая единица измерения (строка-юнит) выбрана в текущем перебираемом столбце
                let selectedUnitIndex = this.columns[i].selectedUnitIndex;

                // вытащим из юнита, выбранного в этом столбце: функцию перевода на основании currentUnitFormula
                let convertToCurrent = new Function("x", "return parseFloat(" + this.units[selectedUnitIndex].currentUnitFormula + ");");

                // переводим funcFromSI в текущую единицу измерения текущего столбца
                this.columns[i].value = convertToCurrent(defaultValue);

                // ---ДОПОЛНИТЕЛЬНО ПОСЛЕ КОНВЕРТАЦИИ---
                // обновляем стандартный вид числа для сконвентированного выражения
                this.columns[i].value10 = this.getValue10(this.columns[i].value);

                // когда JS будет переводить наши числа в свой e+21 формат -- мы будем переводить это число к обратному виду в форме строки
                if (this.columns[i].value10.stepen10 > 20 || this.columns[i].value10.stepen10 < -6) // сие случается, когда порядок числа переваливает за 20 и -6
                    this.columns[i].value = this.eNumberToNormalNumberLongString(this.columns[i].value);

            }
        },

        // переводит 0.0039 => 3.9 * 10 ^ -3. Для спец. отображения в системе SI
        getValue10(value) {
            let isNegative = false;
            if (value < 0) {
                isNegative = true;
                value = value * (-1);
            }
            // КОНСТАНТА, сколько знаков после запятой выводятся:
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
            // standartValue - число с плавающей запятой типа 1,25
            // stepen10 - это положительная или отрицательная степень 10-ти
            function setResult(standartValue, stepen10) {
                // округляем число с плавающей запятой до ostatokCount знаков после запятой
                standartValue = standartValue.toFixed(ostatokCount);

                // целая часть числа
                result.part1 = Math.trunc(standartValue);

                // то, что после запятой: получим в текстовом виде c фиксом до ostatokCount знаков после запятой, без нулей в конце
                let ostatokString = (standartValue - result.part1).toFixed(ostatokCount) * 1;
                result.part2 = ostatokString.toString().replace(/0\./, ''); // убрали 0.

                // зададим степень десяти
                result.stepen10 = stepen10;

                // не забудем вернуть минус, если число было отрицательным
                if (isNegative) result.part1 *= (-1);

                // костыль для 99999999999 и 0.9999999999999. При округлении part1 становится 10
                if (result.part1 === 10) {
                    result.part1 = 1; result.stepen10 = result.stepen10 + 1;
                }
            }

            // РАССМОТРИМ ТРИ СЛУЧАЯ:
            // число не нужно приводить к стандартному виду, только округлить
            if (value >= 1 && value < 10 || value === 0) {
                // число приводится к стандартному виду, а степень 10 устанавливается как 0
                setResult(value, 0);
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
                console.log('standartValue меньше 1: ' + standartValue);
                // число приводится к стандартному виду, а степень 10 устанавливается как counter
                setResult(standartValue, -counter);
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
            }

            // возвращаем заданный и нормированный функцией setResult результат
            return result;
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
    // после монтирования
    this.selectCalculator(this.index);
}

}
</script>
