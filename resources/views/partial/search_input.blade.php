<div class="input-group">
    <input type="text" v-model="txtbuscar" @keyup.enter="buscar(false)" class="form-control" placeholder="Buscar...."/>
    <div class="input-group-append">
        <button class="btn btn-secondary" @click="buscar(false)">
        <template v-if="requestSend">
            <span class="spinner-border spinner-border-sm" role="status"></span><span class="sr-only">Buscando...</span> Cargando...
        </template>
        <template v-else>
            <span class="fa fa-search"></span> Buscar
        </template>
        </button>
    </div>
</div>
	           