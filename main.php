<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Carrinho de compras - desafio</title>
    <style>
        body{font-size: 24px; text-align: center; position: relative}
        .botao-calcular{font-size: 32px; padding: 10px}
        input[type="number"]{font-size: 20px; margin: 10px}
        .info{
            text-align: center;
        }
        .resumo-compra {
            position: absolute;
            text-align: right;
            margin-right: 50px;
            top: 50px;
        }
        .textboxes-info{
            top: 40%;
            right: 12%;
        }
    </style>
    <script>
        function mostrarFields() {
            var secaoCartao = document.getElementById("cc-info");
            var secaoCartaoPrazo = document.getElementById("cc-info-prazo");
            var radioCartao = document.getElementById("credito");
            var radioCartaoPrazo = document.getElementById("credito-prazo");


            if (radioCartao.checked){
                secaoCartao.style.display = 'block';
                secaoCartaoPrazo.style.display = 'none';
            }else if (radioCartaoPrazo.checked){
                secaoCartaoPrazo.style.display = 'block';
                secaoCartao.style.display = 'none';
            } else {
                secaoCartao.style.display = 'none';
                secaoCartaoPrazo.style.display = 'none';


            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('input[name="pagamento"]').forEach(function(radio) {
                radio.addEventListener('change', mostrarFields);
            });
        });
    </script>
</head>
<body>
<h1>Loja - Selecione os produtos</h1>
<form action="main.php" method="post">
    <div>
        <label>Camiseta azul- R$50,00 <input type="number" name="qt_camiseta_azul"    value="0" min="0" max="32" ></label><br>
        <label>Camiseta verde - R$55,00 <input type="number" name="qt_camiseta_verde" value="0" min="0" max="32" ></label><br>
        <label>Calça  marrom- R$55,00 <input type="number" name="qt_camiseta_marrom"  value="0" min="0" max="32" ></label><br>
        <label>Calça bege - R$75,00 <input type="number" name="qt_camiseta_bege"      value="0" min="0" max="32" ></label><br>
        <label>Calça jeans - R70,00 <input type="number" name="qt_calça_jeans"        value="0" min="0" max="32" ></label><br>
        <label>Relógio - R$325,00 <input type="number" name="qt_relogio"              value="0" min="0" max="32" ></label><br>
        <label>Brinco- R$98,00 <input type="number" name="qt_brinco"                  value="0" min="0" max="32" ></label><br>
        <label>Pulseira - R$30,00 <input type="number" name="qt_pulseira"             value="0" min="0" max="32" ></label><br>
        <label>Sapato - R$230,00 <input type="number" name="qt_sapato"                value="0" min="0" max="32" ></label><br>
        <label>Meia - R$20,00 <input type="number" name="qt_meia"                     value="0" min="0" max="32" ></label><br>
    </div>
    <div class="info">
        <h3>Formas de pagamento</h3>
        <input type="radio" name="pagamento" value="pix"> PIX
        <input type="radio" name="pagamento" id="credito" value="credito-a-vista"> Cartão de crédito à vista
        <input type="radio" name="pagamento" id="credito-prazo" value="credito-a-prazo"> Cartão de crédito à prazo
        <br><br>

        <div class="textboxes-info">
            <div id="cc-info" style="display: none;">
                <h3>Informações do Cartão de Crédito</h3>
                <div>
                    <label>Nome no cartão:
                        <input type="text" name="nome_cartao">
                    </label><br>
                    <label>Número do cartão:
                        <input type="text" name="numero_cartao">
                    </label><br>
                    <label>Validade (MM/AA):
                        <input type="text" name="validade_cartao">
                    </label><br>
                    <label>CVV:
                        <input type="text" name="cvv_cartao">
                    </label><br>
                </div>
            </div>
        <div id="cc-info-prazo" style="display: none;">
            <h3>Informações do Cartão de Crédito (à prazo)</h3>
            <div>
                <label>Nome no cartão:
                    <input type="text" name="nome_cartao_prazo">
                </label><br>
                <label>Número do cartão:
                    <input type="text" name="numero_cartao_prazo">
                </label><br>
                <label>Validade (MM/AA):
                    <input type="text" name="validade_cartao_prazo">
                </label><br>
                <label>CVV:
                    <input type="text" name="cvv_cartao_prazo">
                </label></br>
                <label>Número de parcelas:
                <select name="parcelas">
                    <option value="2">2x</option>
                    <option value="3">3x</option>
                    <option value="4">4x</option>
                    <option value="5">5x</option>
                    <option value="6">6x</option>
                    <option value="7">7x</option>
                    <option value="8">8x</option>
                    <option value="9">9x</option>
                    <option value="10">10x</option>
                    <option value="11">11x</option>
                    <option value="12">12x</option>
                </select>
                </label><br>
            </div>
        </div>
    </div>
    <br>
    <input type="submit" name="comprar" class="botao-calcular" value="Comprar">
</form>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function calcular_com_juros($valor, $parcelas) {
    $juros = 0.01; // 1%
    return $valor * pow(1 + $juros, $parcelas);
}
function desconto($valor, $pagamento) {
    if ($pagamento === 'pix') {
        return $valor * 0.9;
    }
    return $valor;
}
function exibir_resumo($total, $pagamento, $parcelas = null) {
    echo "<div class='resumo-compra'>";
    echo "<h2>Resumo da Compra:</h2>";

    $produtos = [
        'qt_camiseta_azul' => ['nome' => 'Camiseta azul', 'preco' => 50.00],
        'qt_camiseta_verde' => ['nome' => 'Camiseta verde', 'preco' => 55.00],
        'qt_camiseta_marrom' => ['nome' => 'Calça marrom', 'preco' => 55.00],
        'qt_camiseta_bege' => ['nome' => 'Calça bege', 'preco' => 75.00],
        'qt_calça_jeans' => ['nome' => 'Calça jeans', 'preco' => 70.00],
        'qt_relogio' => ['nome' => 'Relógio', 'preco' => 325.00],
        'qt_brinco' => ['nome' => 'Brinco', 'preco' => 98.00],
        'qt_pulseira' => ['nome' => 'Pulseira', 'preco' => 30.00],
        'qt_sapato' => ['nome' => 'Sapato', 'preco' => 230.00],
        'qt_meia' => ['nome' => 'Meia', 'preco' => 20.00]
    ];

    echo "<h3>Itens:</h3>";
    foreach ($produtos as $key => $produto) {

        if(isset($_POST[$key])){
            $quantidade = intval($_POST[$key]);
        } else {
            $quantidade = 0;
        }

        if ($quantidade > 0) {
            $subtotal = $quantidade * $produto['preco'];
            echo "<p>{$produto['nome']} - {$quantidade} x R$ " . number_format($produto['preco'], 2, ',', '.') .
                " = R$ " . number_format($subtotal, 2, ',', '.') . "</p>";
        }
    }

    echo "<p>Total: R$ " . number_format($total, 2, ',') . "</p>";
    if ($pagamento === 'pix') {
        echo "<p>Forma de pagamento: PIX (10% de desconto aplicado)</p>";
    } elseif ($pagamento === 'credito-a-vista') {
        echo "<p>Forma de pagamento: Cartão de Crédito à Vista</p>";
    } elseif ($pagamento === 'credito-a-prazo') {
        echo "<p>Forma de pagamento: Cartão de Crédito à Prazo</p>";
        echo "<p>Parcelado em $parcelas vezes</p>";
    }
    echo "</div>";
}


function preco_final() {
    $produtos = [
        'qt_camiseta_azul' => 50.00,
        'qt_camiseta_verde' => 55.00,
        'qt_camiseta_marrom' => 55.00,
        'qt_camiseta_bege' => 75.00,
        'qt_calça_jeans' => 70.00,
        'qt_relogio' => 325.00,
        'qt_brinco' => 98.00,
        'qt_pulseira' => 30.00,
        'qt_sapato' => 230.00,
        'qt_meia' => 20.00
    ];

    $valor_total = 0;

    foreach ($produtos as $key => $value) {
        $quantidade = intval($_POST[$key]);
        $valor_total += $quantidade * $value;
    }

    return $valor_total;
}

if (isset($_POST['comprar'])) {
    if (!isset($_POST['pagamento'])) {
        echo "<p>Por favor, selecione uma forma de pagamento.</p>";
    } else {
        $pagamento = $_POST['pagamento'];
        $total_sem_desconto = preco_final();

        if ($pagamento === 'pix') {
            $total = desconto($total_sem_desconto, $pagamento);
            exibir_resumo($total, $pagamento);
        } elseif ($pagamento === 'credito-a-vista') {
            $dados_obrigatorios = ['nome_cartao', 'numero_cartao', 'validade_cartao', 'cvv_cartao'];
            foreach ($dados_obrigatorios as $field) {
                if (empty($_POST[$field])) {
                    echo "<p>Por favor, preencha todos os campos do cartão de crédito.</p>";
                    return;
                }
            }
            exibir_resumo($total_sem_desconto, $pagamento);
        } elseif ($pagamento === 'credito-a-prazo') {
            $dados_obrigatorios = ['nome_cartao_prazo', 'numero_cartao_prazo', 'validade_cartao_prazo', 'cvv_cartao_prazo', 'parcelas'];
            foreach ($dados_obrigatorios as $field) {
                if (empty($_POST[$field])) {
                    echo "<p>Por favor, preencha todos os campos do cartão de crédito à prazo.</p>";
                    return;
                }
            }
            $parcelas = intval($_POST['parcelas']);
            $total_com_juros = calcular_com_juros($total_sem_desconto, $parcelas);
            exibir_resumo($total_com_juros, $pagamento, $parcelas);
        } else {
            echo "<p>Forma de pagamento inválida.</p>";
        }
    }
}
?>
</body>
</html>