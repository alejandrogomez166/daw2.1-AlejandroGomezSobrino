window.onload = inicializaciones;
var tablaCategorias;
// TODO ¿Útil para mantener un control de eliminaciones, etc.?     var categorias;



function inicializaciones() {
    tablaCategorias = document.getElementById("tablaCategorias");
    document.getElementById('submitCrearCategoria').addEventListener('click', clickCrearCategoria);

    cargarTodasLasCategorias();
}

function cargarTodasLasCategorias() {
    
    var request = new XMLHttpRequest();

    request.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var categorias = JSON.parse(this.responseText);

            for (var i=0; i<categorias.length; i++) {
                insertarCategoria(categorias[i]);
            }
        }
    };

    request.open("GET", "CategoriaObtenerTodas.php");
    request.send();
}

function clickCrearCategoria() {
    var nombreCategoria = document.getElementById("nombre");
    var nuevaCategoria;

    nuevaCategoria =nombreCategoria.value;
    
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {

    
    if(this.readyState==4 && this.status == 200){
        var categoria = JSON.parse(this.responseText);
        insertarCategoria(categoria);
    }
        };
        request.open("GET","CategoriaCrear.php?nombre="+nuevaCategoria,true);
        request.send();
        

    // Recoger datos del form.
    // Limpiar los datos en el form: .clear()
    // Crear un XMLHttpRequest. Enviar en la URL los datos de la categoria: CategoriaCrear.php?nombre=blablabla
    // Recoger la respuesta del request. Vendrá un objeto categoría.
    // Llamar con ese objeto a insertarCategoria(categoria);
}

function insertarCategoria(categoria) {
    // TODO Que la categoría se inserte en el lugar que le corresponda según un orden alfabético.
    // Usar esto: https://www.w3schools.com/jsref/met_node_insertbefore.asp

    var tr = document.createElement("tr");
    var td = document.createElement("td");
   
    var btn = document.createElement("button");
    var td2= document.createElement("td");

    td.setAttribute("id",categoria.id);
    tr.setAttribute("id",categoria.id);
    var textoContenido = document.createTextNode(categoria.nombre);
    td.addEventListener("click",function(){modificarCategoria(categoria,td)});
    btn.appendChild(document.createTextNode("X"));
    btn.addEventListener("click",eliminarCategoria);
    btn.setAttribute("style","background-color:red");


    
    td.appendChild(textoContenido);
    td2.appendChild(btn);
    tr.appendChild(td);
    tr.appendChild(td2);
    tablaCategorias.appendChild(tr);
    ordenatabla(tablaCategorias);
}

function eliminarCategoria(e) {
	
    // TODO Pendiente de hacer.
    var id = e.target.parentNode.parentNode.id;
    
    
    var request = new XMLHttpRequest();
    request.onreadystatechange = function() {

    
    if(this.readyState==4 && this.status == 200){

       document.getElementById(id).remove();
        
    }
        };
    request.open("GET","CategoriaEliminar.php?id="+id,true);
    request.send();


}

function modificarCategoria(categoria,td) {
    var input = document.createElement("input");
    input.setAttribute("type","text");
    input.setAttribute("value",categoria.nombre);
    input.setAttribute("id",categoria.id);
    td.parentNode.replaceChild(input,td);
    
    input.addEventListener("blur",function(){guardarCategoria(categoria,input)});
}
   function guardarCategoria(categoria,input){
   		
		var request = new XMLHttpRequest();
		request.onreadystatechange = function () {
        	if (this.readyState == 4 && this.status == 200) {
        		
        		var td= document.createElement("td");
    			td.setAttribute("id",categoria.id);
				var textoContenido = document.createTextNode(input.value);
    			td.appendChild(textoContenido);
    			td.addEventListener("click",function(){modificarCategoria(categoria,td)});
    			input.parentNode.replaceChild(td,input);
    			ordenatabla(tablaCategorias);
        	}
   		};
   		request.open("GET", "CategoriaModificar.php?nombre="+input.value + "&id="+input.id , true);
   		request.send();

    	
    }
    //ordena la tabla que se le pase que tenga dos elementos por fila
    function ordenatabla(tabla){
        
    var table, rows, switching, i, x, y, shouldSwitch;
    table = tabla;
    switching = true;
    
    while (switching) {
       
        switching = false;
        rows = table.rows;
       
        for (i = 1; i < (rows.length - 1); i++) {
            
            shouldSwitch = false;
            
            x = rows[i].getElementsByTagName("TD")[0];
            y = rows[i + 1].getElementsByTagName("TD")[0];
            
            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                
                shouldSwitch = true;
                break;
            }
        }
        if (shouldSwitch) {
           
            rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
            switching = true;
        }
    }
}
    

  

// TODO Actualizar lo local si actualizan el servidor. Poner timestamp de modificación en la tabla y pedir categoriaObtenerModificadasDesde(timestamp)