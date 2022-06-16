<?php
	include('../conexao.php');

	$descricao = $_POST['descricao'];
	
	$where = "";
	if($descricao != ""){
		$where = " WHERE usuario.nome_usuario LIKE '%".trim($descricao)."%'";
	}
    $sql = "SELECT * FROM usuario " . $where . " ORDER BY usuario.id";

	$query = mysqli_query($conexao, $sql);
	if(!$query) {
		echo mysqli_error($conexao);
	} else {
		while($item = mysqli_fetch_array($query, MYSQLI_ASSOC)){

?>
<tr>
    <td><?php echo $item['id']?></td>
    <td><?php echo $item['nome_usuario']?></td>
    <td><?php echo $item['email']?></td>
    <td><?php echo date('d/m/Y H:i:s',strtotime($item['data_cadastro']));?></td>
    <td><?php if($item['data_atualizacao']){echo date('d/m/Y H:i:s',strtotime($item['data_atualizacao']));}?></td>
    <td><?php echo $item['tipo'] == 'A'?'Administrador':'Normal';?></td>                                    
    <td><?php echo $item['status'] == 'A'?'Ativo':'Inativo';?></td>
    <td><a href="usuario-editar.php?id=<?php echo $item['id']?>"><img src="../assets/editar.png" alt="Editar" title="Editar"></a></td>
	<td id="<?php echo $item['id']?>"><input type="hidden" name="idExcluir" id="idExcluir" value=""><img src="../assets/excluir.png" alt="Excluir" title="Excluir" id="btnExcluir"></td>
</tr>				
<?php
		}
	}
	mysqli_close($conexao);
?>
<script type="text/javascript" src="../jquery.js"></script>
<script type="text/javascript">
	$(document).ready(function () {
		$('img#btnExcluir').on('click', function () {
            var idExclusao = $(this).closest('td').attr("id");
            var linha = $(this).closest('tr');
            if(confirm("Deseja excluir o cadastro?")){
                $.ajax({
                    url: '../controllers/usuario/usuario-excluir.php?id=' + idExclusao,
                    method: 'GET',
                }).done(function(retorno){
                    if(retorno){
                        alert(retorno);
                    } else {
                        linha.remove();
                    }                    
                });
            }            
		});
	});   
</script>