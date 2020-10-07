	//const axios = require('axios').default;
	var app = new Vue({
  el: '#app',
  data: {
    usuario:'Seleccionar',
  	usuarios:[],
  	password:'',
  	error:''
  },
  methods: {
    getUser:function(){
      var url='<?php route("showalluser")?>';
      axios.get(url)
      .then(response=>{
        this.usuarios= response.data;
      })
      .catch(e=>{
        this.error= e.message;
      })
    },
    enviar: function () {
    	var url='<?php route("login@login")}} ?>';
    	if(this.usuario.length>0 && this.password.length>0){
    		axios.post(url,{
    			usuario: this.usuario,
    			password: this.password
    		})
    		.then(response=>{
    			if(response.data.estado==2){
    				this.error= response.data.data;
    			}else{
    				window.location.href="";//********************************************
    			}
    		})
    		.catch(e=>{
    			this.error= e.message;
    		});
    	}else{
    		this.error="Complete los campos!";
    	}
    }
  },
  mounted(){
    this.getUser();
  }
})