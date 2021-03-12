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
                    { selectedUnitIndex:0, value:1.0 },
                    { selectedUnitIndex:0, value:1.0 }
                ],
                isActive: false,



            }
        },
        methods: {
            // Выбор калькулятора из выпадающего списка по индексу i
            selectCalculator(i)
            {
                // при переключении калькулятора будут 2 столбца, в котором будут выбраны первые строки
                this.columns = [
                    { selectedUnitIndex:0, value:1.0 },
                    { selectedUnitIndex:0, value:1.0 }
                ];
                // обновляем текущий индекс выпадающего списка
                this.index = i;
                // обновляем список текущих единиц измерения
                this.units = this.calculators[i].units;


                console.log('Переключил на: ' + this.calculators[i].name);
            },

            selectUnit(unitRowIndex, columnIndex)
            {
                console.log('В столбце ['+columnIndex+'] выбрана строка ['+unitRowIndex+']');

                // записываем активный юнит-строку столбца columnIndex
                this.columns[columnIndex].selectedUnitIndex = unitRowIndex;

                // вызываем конвертацию из другого столбца, но только не из этого
                let tempColumn = columnIndex===0?1:0; // если это 0 -- выбираем 1, а если это не 0, то выбираем 0
                this.convertFromThisColumn(tempColumn);

            },

            // добавляет или не добавляет класс "active" к строке-юниту
            isActiveUnit(unitRowIndex, columnIndex)
            {
                if (this.columns[columnIndex].selectedUnitIndex === unitRowIndex)
                    return("active");
                else return("");
            },

            // производит конвертацию величин. в качестве аргумента указывается номер столбца, изменение которого инициирует конвертацию
            convertFromThisColumn(columnIndex)
            {

                // значение изменённого столбца
                let value = this.columns[columnIndex].value;

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
                    console.log('Предотвращение NaN');
                    value = 0;
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


                }

            },

            // возвращает функцию из строкового представления тела функции
            getFunction(stringBody)
            {
                // определим функцию перевода в SI
                let functionBody = "return parseFloat(" + stringBody + ");";
                return new Function("x", functionBody);
            }
        }

    }
</script>
