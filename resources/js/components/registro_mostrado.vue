<template>
<span v-if="total>0">Pag. <strong>{{ pagina_actual }}</strong> mostrando ({{ desde }} - {{ hasta }}) de {{ total }} registros</span>
</template>
<script>
export default{
    name: 'registro_mostrado',
    props: ["pagina_actual","desde","hasta","total"]
}
</script>