<!DOCTYPE html>
 <html>
 <head>
<title>Calculadora</title>
</head>
<body>
	
<label>Introduce la operación que quieres hacer</label>
 <form name="f1" method="post" action="Calculadora2.php">

<select name="Calculadora">
  <option value="sum">Sumar</option>
  <option value="res">Restar</option>
  <option value="mul">Multiplicar</option>
  <option value="div">Dividir</option>
</select>

  <input type="number" name="numero">
  <input type="number" name="numero2">
  <input type="submit" value="Enviar">
    </form>




</body>

</html>