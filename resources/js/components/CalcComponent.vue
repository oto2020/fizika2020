<template>
    <div>
        <div class="dropdown">
            <button type="button" class="btn btn-lg btn-dark dropdown-toggle" data-toggle="dropdown" >
                {{calculators[index].name}}
            </button>
            <div class="dropdown-menu">
                <a v-for="(calc, i) in calculators" @click="selectCalculator(i)" class="dropdown-item"  href="#">{{calc.name}}</a>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col" v-for="(column, columnIndex) in columns">
                <label>Введите значение:</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text">{{units[column.selectedUnitIndex].symbol}}</span>
                    </div>
                    <input v-model="columns[columnIndex].value" @input="convertFromThisColumn(columnIndex)" type="text" class="form-control"  aria-describedby="basic-addon3" >
                    <div class="input-group-append">
                        <span class="input-group-text">{{columns[columnIndex].value10.part1}}.{{columns[columnIndex].value10.part2}}&times;10<sup>{{columns[columnIndex].value10.stepen10}}</sup></span>
                    </div>
                </div>


                <ul class="list-group">
                    <li v-for="(unit, unitRowIndex) in units" @click="selectUnit(unitRowIndex, columnIndex)" class="list-group-item":class= "isActiveUnit(unitRowIndex, columnIndex)" >
                        <div class="float-left">{{unit.symbol}} </div>
                        <div class="float-right">{{unit.name}} </div>
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
                    { selectedUnitIndex:0, value:1.0, value10:{part1:1, part2:0, stepen10:0} },
                    { selectedUnitIndex:0, value:1.0, value10:{part1:1, part2:0, stepen10:0} }
                ],



            }
        },
        methods: {
            // Выбор калькулятора из выпадающего списка по индексу i
            selectCalculator(i)
            {
                // при переключении калькулятора будут 2 столбца, в котором будут выбраны первые строки
                this.columns = [
                    { selectedUnitIndex:0, value:1.0, value10:{part1:1, part2:0, stepen10:0} },
                    { selectedUnitIndex:0, value:1.0, value10:{part1:1, part2:0, stepen10:0} }
                ];
                // обновляем текущий индекс выпадающего списка
                this.index = i;
                // обновляем список текущих единиц измерения
                this.units = this.calculators[i].units;


                console.log('Переключил на: ' + this.calculators[i].name);
            },

            // Выбор юнита-строки unitRowIndex из столбца columnIndex
            selectUnit(unitRowIndex, columnIndex)
            {
                console.log('В столбце ['+columnIndex+'] выбрана строка ['+unitRowIndex+']');

                // записываем активный юнит-строку столбца columnIndex
                this.columns[columnIndex].selectedUnitIndex = unitRowIndex;

                // вызываем конвертацию из другого столбца, но только не из этого
                let tempColumn = columnIndex===0?1:0; // если это 0 -- выбираем 1, а если это не 0, то выбираем 0
                this.convertFromThisColumn(tempColumn);

            },

            // возвращает название класса, который добавляется в зависимости от того, выделен ли юнит unitRowIndex в столбце columnsIndex
            isActiveUnit(unitRowIndex, columnIndex)
            {
                if (this.columns[columnIndex].selectedUnitIndex === unitRowIndex)
                    return("active");
                else return("");
            },

            // производит конвертацию величин. в качестве аргумента указывается столбец columnIndex, изменение которого инициирует конвертацию
            convertFromThisColumn(columnIndex)
            {
                // значение изменённого столбца
                let value = this.columns[columnIndex].value;

                if (parseFloat(value) !== parseFloat(value))
                {
                    console.log('Предотвращение пустой строки');
                    value = 0;
                }

                // обновляем стандартный вид числа для столбца, в котором производились изменения
                this.columns[columnIndex].value10 = this.getValue10(value);

                console.log('Конвертируем. Инициатор столбец номер: ' + columnIndex);

                // определим текущую активную строку столбца, по которому кликнули или редактировани input
                let unitRowIndex = this.columns[columnIndex].selectedUnitIndex;

                // определим функцию перевода в SI
                let convertToSI = this.getFunction(this.units[unitRowIndex].toSI);

                // Переводим изменённое значение в SI:
                let valueSI = convertToSI(value);
                console.log('Получено значение в системе SI: ' + valueSI + ' ' + this.calculators[this.index].symbolSI);
                if (valueSI !== valueSI)
                {
                    console.log('Предотвращение NaN 2');
                    this.columns[columnIndex].value = 1;
                }

                // Пробежимся по всем столбцам и переведём fromSI
                for (let i = 0; i < this.columns.length; i++)
                {
                    // текущий столбец не трогаем
                    if (i === columnIndex) continue;

                    // какая строка-юнит выбрана в текущем перебираемом столбце
                    let selectedUnitIndex = this.columns[i].selectedUnitIndex;

                    // вытащим из юнита, выбранного в этом столбце: функцию перевода fromSI
                    let convertFromSI = this.getFunction(this.units[selectedUnitIndex].fromSI);

                    // переводим fromSI в текущую единицу измерения текущего столбца
                    this.columns[i].value = convertFromSI(valueSI);

                    // обновляем стандартный вид числа для сконвентированного выражения
                    this.columns[i].value10 = this.getValue10(this.columns[i].value);
                }
            },

            // переводит 0.0039 => 3.9 * 10 ^ -3
            getValue10(value)
            {
                let isNegative = false;
                if (value < 0)
                {
                    isNegative = true;
                    value = value*(-1);
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
                function setResult(standartValue, stepen10)
                {
                    // округляем до ostatokCount знаков после запятой
                    standartValue = standartValue.toFixed(ostatokCount);

                    // целая часть числа
                    result.part1 = Math.trunc(standartValue);

                    // преобразуем то, что после запятой: получим в текстовом виде c фиксом до ostatokCount знаков после запятой, без нулей в конце
                    let ostatokString = (standartValue - result.part1).toFixed(ostatokCount) * 1;
                    result.part2=ostatokString.toString().replace(/0\./,''); // убрали 0.

                    // зададим степень десяти
                    result.stepen10 = stepen10;

                    // не забудем вернуть минус, если число было отрицательным
                    if (isNegative) result.part1 *= (-1);
                }
                // число не нужно приводить к стандартному виду, только округлить
                if (value >= 1 && value < 10 || value === 0)
                {
                    // число приводится к стандартному виду, а степень 10 устанавливается как 0
                    setResult(value, 0);
                    console.log('standartValue: ' + value);
                    return result;
                }
                // если значение меньше 1, значит нам нужно будет умножать на 10 пока значение на станет >= 1 и < 10
                if (value < 1)
                {
                    // сняли копию
                    let standartValue = value;
                    let counter = 0;
                    while(!(standartValue >= 1 && standartValue < 10))
                    {
                        counter++;
                        standartValue *= 10;
                        if (counter > 16)
                        {
                            counter = ' < -16';
                            break;
                        }
                    }
                    console.log('standartValue: ' + standartValue);
                    // число приводится к стандартному виду, а степень 10 устанавливается как counter
                    setResult(standartValue, -counter);
                    return result;
                }
                // если значение меньше 1, значит нам нужно будет умножать на 10 пока значение на станет >= 1 и < 10
                if (value >=10)
                {
                    // сняли копию
                    let standartValue = value;
                    let counter = 0;
                    while(!(standartValue >= 1 && standartValue < 10))
                    {
                        counter++;
                        standartValue /= 10;
                        if (counter > 16)
                        {
                            counter = ' > 16'
                            break;
                        }
                    }
                    console.log('standartValue: ' + standartValue);
                    // число приводится к стандартному виду, а степень 10 устанавливается как counter
                    setResult(standartValue, counter);
                    return result;
                }
            },

            // создает функцию из строкового представления тела функции
            getFunction(stringBody)
            {
                // определим функцию перевода в SI
                let functionBody = "return parseFloat(" + stringBody + ");";
                return new Function("x", functionBody);
            }
        }

    }
</script>
