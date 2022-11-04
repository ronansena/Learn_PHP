
<?php

require_once('../repo.php');
require_once('conexao.php');

switch (get_post_action('inclusao', 'alteracao',  'Deletar')) {

    case 'inclusao':

        if (empty(trim($_POST['nomeProdutoAlterado']))) {

            echo ("<SCRIPT LANGUAGE='JavaScript'>window.alert('Informe o nome da produto!');</SCRIPT>");
            echo "<script>window.history.back()</script>";
        } else {

            $nomeProduto = trim($_POST['nomeProdutoAlterado']);
            $categoriadesp = $_POST['categoriadesp'];

            if (!empty($_POST['subcategoriadesp'])) {
                $subcategoriadesp = $_POST['subcategoriadesp'];
            } else {
                $subcategoriadesp = 'NULL';
            }

            $search1 = mysqli_query($conect, "SELECT * FROM produto WHERE nomeProduto = '$nomeProduto'");

            if (mysqli_num_rows($search1) > 0) {

                echo ("<SCRIPT LANGUAGE='JavaScript'>
                    window.alert('Essa produto já existe no cadastro!'); </SCRIPT>");
                echo "<script>window.history.back()</script>";
            }

            if (mysqli_num_rows($search1) === 0) {

                $sqlUltimoIdProduto = "SELECT idProduto
                    FROM produto
                    ORDER BY idProduto desc
                    LIMIT 1";

                $resultUltimoIdProduto  =  mysqli_query($conect, $sqlUltimoIdProduto); // Run the query.

                $lastIdUltimoIdProduto  = mysqli_fetch_row($resultUltimoIdProduto);

                $lastIdUltimoIdProduto[0] =  $lastIdUltimoIdProduto[0] + 1;

                $q = "INSERT INTO produto (idProduto,nomeproduto,idcategoriaDespesa,idsubcategoriaDespesa)
                    VALUES ($lastIdUltimoIdProduto[0],'$nomeProduto',$categoriadesp,$subcategoriadesp)";

                $conect->autocommit(FALSE);

                $result =  mysqli_query($conect, $q);

                if ($result) {
                    $conect->commit();
                    echo ("<SCRIPT LANGUAGE='JavaScript'>
                                        window.alert('Produto incluído com sucesso!');</SCRIPT>");
                } else {
                    echo ('<script>window.alert("System Error: 
                                                You could not be registered due to a system error. We apologize for any inconvenience.")</script>');
                    echo "<script>window.history.back()</script>";
                    $conect->rollback();
                }
            }
            $conect->close();
            echo "<script>window.close();</script>";
            echo "<script>window.setTimeout(function(){location.href = '../searchProduto.php';},10);</script>";
        }

        break;

    case 'alteracao':

        $nomeProdutoAlteracao = $_POST['nomeProdutoAlterado'];
        $nomeProdutoOriginal = $_POST['nomeProdutoOriginal'];
        $categoriadesp = $_POST['categoriadesp'];

        if (!empty($_POST['subcategoriadesp'])) {

            $subcategoriadesp = $_POST['subcategoriadesp'];
        } else {

            $subcategoriadesp = 'NULL';
        }

        $q = "update produto set nomeproduto='$nomeProdutoAlteracao' where nomeProduto='$nomeProdutoOriginal'";

        $conect->autocommit(FALSE);

        $result = mysqli_query($conect, $q);

        if ($result) {
            $conect->commit();

            echo "<script>window.alert('Registro alterado com sucesso!')</script>";
            echo "<script>window.close();</script>";
            echo "<script>window.setTimeout(function(){location.href = '../searchProduto.php';},10);</script>";
        } else {

            echo ('<script>window.alert("System Error: 
                                    You could not be registered due to a system error. We apologize for any inconvenience.")</script>');
            echo "<script>window.history.back()</script>";

            $conect->rollback();
        }

        break;



    case 'Deletar':


        if (empty($_POST['idProduto'])) {

            echo "<script>window.alert('É obrigatório selecionar um registro para deletar!')</script>";
            echo "<script>window.history.back()</script>";
        } else {


            $idProduto = $_POST['idProduto'];
            $idcategoriaDespesa = $_POST['idcategoriaDespesa'];
            $idsubcategoriaDespesa = $_POST['idsubcategoriaDespesa'];

            //$intervalo = explode( ',', sprintf( "'%s'", implode( '","', $nomeProduto ) ) );

            $intervaloProduto =  sprintf('%s', implode(',', $idProduto));
            $intervaloCategoria =  sprintf('%s', implode(',', $idcategoriaDespesa));
            $intervaloSubCategoria =  sprintf('%s', implode(',', $idsubcategoriaDespesa));

            if (!empty($intervaloSubCategoria)) {     // deletar a cotação e produto COM subcategoria         

                $queryDeletePrecoProduto = "delete from preco where idProduto in ($intervaloProduto)
                    and idcategoriaDespesa in ($intervaloCategoria)
                    and idsubcategoriaDespesa in ($intervaloSubCategoria)";

                $resultDeletePrecoProduto = $conect->query($queryDeletePrecoProduto);

                $resultDeletePrecoProduto = mysqli_query($conect, $queryDeletePrecoProduto);

                if ($resultDeletePrecoProduto) { // deletar o produto

                    $queryDeleteProduto = "delete from produto where idProduto in ($intervaloProduto)
                        and idcategoriaDespesa in ($intervaloCategoria)
                        and idsubcategoriaDespesa in ($intervaloSubCategoria)";

                    $resultDeleteProduto = $conect->query($queryDeleteProduto);
                    $resultDeleteProduto = mysqli_query($conect, $queryDeleteProduto);


                    if ($resultDeleteProduto) {

                        echo "<script>window.alert('Registro deletado com sucesso!')</script>";
                        $conect->close();
                        echo ('<script>window.location="../searchProduto.php";</script>');
                    } else {

                        echo "<script>window.alert('Falha ao tentar deletar o registro! É necessário selecionar pelo menos um produto e uma categoria para deletar o registro.')</script>";
                        $conect->close();

                        echo "<script>window.history.back()</script>";
                    }
                } else {

                    echo "<script>window.alert('Falha ao tentar deletar o registro as cotações para o produto! Favor verificar!')</script>";

                    $conect->close();

                    echo "<script>window.history.back()</script>";
                }
            } else { // deletar a cotação e produto SEM subcategoria  


                $queryDeletePrecoProduto = "delete from preco where idProduto in ($intervaloProduto)
                and idcategoriaDespesa in ($intervaloCategoria)";

                $resultDeletePrecoProduto = $conect->query($queryDeletePrecoProduto);

                $resultDeletePrecoProduto = mysqli_query($conect, $queryDeletePrecoProduto);

                if ($resultDeletePrecoProduto) { // deletar o produto

                    $queryDeleteProduto = "delete from produto where idProduto in ($intervaloProduto)
                    and idcategoriaDespesa in ($intervaloCategoria)";

                    $resultDeleteProduto = $conect->query($queryDeleteProduto);
                    $resultDeleteProduto = mysqli_query($conect, $queryDeleteProduto);


                    if ($resultDeleteProduto) {

                        echo "<script>window.alert('Registro deletado com sucesso!')</script>";
                        $conect->close();
                        echo ('<script>window.location="../searchProduto.php";</script>');
                    } else {

                        echo "<script>window.alert('Falha ao tentar deletar o registro! É necessário selecionar pelo menos um produto e uma categoria para deletar o registro.')</script>";
                        $conect->close();

                        echo "<script>window.history.back()</script>";
                    }
                } else {

                    echo "<script>window.alert('Falha ao tentar deletar o registro as cotações para o produto! Favor verificar!')</script>";

                    $conect->close();

                    echo "<script>window.history.back()</script>";
                }
            }
        }

        break;

    default:
        //no action sent
        exit();
} //fim swicht
?>

    




