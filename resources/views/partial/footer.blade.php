<script src="{{ mix('js/app.js') }}"></script>
    <script type="text/javascript">
        function soloNumero(event)
        {
            if(event.charCode >= 48 && event.charCode <= 57)
            { 
              return true;
            }
            return false; 
        }
        function format(input)
        {
            var num = input.value.replace(/\./g,"");
            num = num.toString().split("").reverse().join("").replace(/(?=\d*\.?)(\d{3})/g,'$1.');
            num = num.split("").reverse().join("").replace(/^[\.]/, "");
            input.value = num;   
        }
        function getSucursal(){
            var id= localStorage.getItem("suc_cod");
            var desc= localStorage.getItem("suc_desc");
            if(desc != null){
                var obj= document.getElementById("sucursal");
                obj.setAttribute('data-id',id);
                obj.innerHTML=" "+desc
            }else{
                var obj= document.getElementById("sucursal");
                obj.innerHTML=" Sel. Sucursal"
            }
            
        }
         
            @auth 
                getSucursal();
            @endauth
    
        
    
    
    </script>
    @yield('script')
