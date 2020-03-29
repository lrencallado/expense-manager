<template>
  <div class="chart-wrapper">
    <table>
        <thead>
            <tr>
                <th width="70%">Expense Categories</th>
                <th width="30%">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr v-bind:style="{color: item.color}" v-for="item in chartData.all">
                <td v-show="index != 'color'" v-for="(value, index) in item">
                    {{ index != 'color' ? 
                    (index == 'expenses_count' ? '$'+(value == null ? 0 : value) : value ) :
                    '' }}
                </td>
            </tr>
        </tbody>
    </table>
    <chart-component
    :chartData="chartData">
    </chart-component>
  </div>
</template>
<script>
export default {
    props:{
        chartData: Object
    },
    data(){
        return{
            record: {},
        }
    }
}
</script>