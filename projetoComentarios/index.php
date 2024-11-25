<?php
try{
    $pdo=new PDO("mysql:dbname=comentarios;host=localhost","root","");
}catch(PDOException $error){
    echo "Problema com a conexão BD: ".$error->getMessage();
}
if(isset($_POST['nome'])&&!empty($_POST['nome'])){
    $nome=$_POST['nome'];
    $msg=$_POST['msg'];

    $sql=$pdo->prepare("INSERT INTO mensagens SET nome = :nome, msg = :msg, data_msg=NOW()");
    $sql->bindValue(":nome",$nome);
    $sql->bindValue(":msg",$msg);
    $sql->execute();
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <fieldset>
        <form method="POST" >
        Nome:
        <input type="text" name="nome" >
        <br><br>
        Mensagem:
        <textarea name="msg" id=""></textarea>
        <br><br>
        <input type="submit" value="Enviar">
        </form>
    </fieldset>
    <br><?php
    $sql="SELECT * FROM mensagens ORDER BY data_msg DESC";
    $sql=$pdo->query($sql);
    if($sql->rowCount()>0){
        foreach($sql->fetchAll() as $mensagemEnviada){
            $dataBr=date("d/m/Y", strtotime($mensagemEnviada['data_msg']));
            echo "<strong>(".$dataBr.")  ".$mensagemEnviada['nome']."<br></strong>";
            echo $mensagemEnviada['msg']."<br> ";
            echo "<hr>";
        }

    }else{
        echo "Esta bem quieto por aqui...";
    }
    
    
    ?>
</body>
</html>