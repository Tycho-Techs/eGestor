<!DOCTYPE html>
<html data-bs-theme="light" lang="pt-BR" dir="ltr">

<?php 

require_once('session-lgin.php');
require_once ('pdoconfig.php');

 require_once('header.php'); 
 require_once('functions.php');


 ?>


<body>
    


  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <div class="container" data-layout="container">

      <?php require_once('navbar-vertical.php'); ?>

      <div class="content">
        <?php require_once('navbar-top.php'); ?>

        <!-- ===============================================-->
        <!--    Page-->
        <!-- ===============================================-->

        <div class="d-flex mb-4 mt-3"><span class="fa-stack me-2 ms-n1"><i
              class="fas fa-circle fa-stack-2x text-300"></i><i
              class="fa-inverse fa-stack-1x text-primary fas fa-list"></i></span>
          <div class="col">
            <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">Lotes de Pagamento</span><span
                class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span></h5>
            <p class="mb-0"></p>
          </div>
        </div>

       <?php 

            try{
                $conn_egestor = new mysqli($host, $username, $password, $dbname);
            }catch (Exception $e) {
                die("Falha na conexão: ".$e->getMessage());
                $temerro++;
            }
            
             // Turn autocommit off
            $conn_egestor -> autocommit(FALSE);
                                    
            if($temerro != 0) $conn_egestor->rollback();
            else{
                $conn_egestor->commit();
            }
                        
            $conn_egestor->close();
            
          
       ?>
       
	       <div class="container">

            <div class="col-lg-0">
              <div class="card h-100" id="paymentHistoryTable" data-list='{"valueNames":["course","invoice","date","amount","status"],"page":5}'>
                <div class="card-header d-flex flex-between-center">
                  <h5 class="mb-0 text-nowrap py-2 py-xl-0">Inserir Pagamentos para o cliente</h5>
                  
                  <div class="dropdown font-sans-serif position-static d-inline-block btn-reveal-trigger">
                      <a class="nav-link" href="https://sweetadm-my.sharepoint.com/:x:/g/personal/administracao_sweetadm_com_br/Efhofm-NX-NNquJHrYxArwUBQVJ4dImp4FTgDbO3c9xGrQ?e=12QOHz" target="_blank">
                        <button class="btn btn-falcon-default btn-sm" type="button">
                          <span class="fas fa-file-excel" data--transform="shrink-3"></span><span class="d-none d-sm-inline-block d-xl-none d-xxl-inline-block ms-1">Carregar por Excel</span>
                        </button>
                      </a>
                    
                    </div>
                    
                </div>
                <div class="card-body p-0">
                  <div class="table-responsive scrollbar">
                    <table class="table mb-0 fs--1 border-200 overflow-hidden" id="BodyTable">
                      <thead class="bg-light text-900 font-sans-serif">
                        <tr>
                          <th style="width: 0.01%;" class="small-width">Nº</th>
                          <th class="col-sm-2 frame-recebimento-col-data">Data</th>
                          <th class="col-sm-2" id="str_frame_pagamento_valor">Valor</th>
                          <th class="col-sm-2" style="">Forma</th>
                          <th class="fr-hide-simplificado pe-12 py-3" data-sort="status">Detalhes</th>
                          <th style="width: 0.01%;" class="small-width"></th>
                        </tr>
                      </thead>
                      <tbody class="list">
                        <tr class="fw-semi-bold">
                          <td>#</td>
                           <td class="frame-recebimento-col-data">
            				<div class="input-group"><input type="text" class="form-control campoInput" name="data" id="data" value="" placeholder="dd/mm/yyyy"></div>
            			    </td>
                          <td><input type="text" class="form-control campoInput" id="valor" value="" placeholder="R$ 0,00" name="valor"></td>
                          
                          <td class="fr-hide-simplificado campoInput" id="colFormaPagamento0" style="display: table-cell;">
                              <select class="form-select campoInput"id="forma" name="forma">
                                  <option value=""></option>
                                  <option value="Dinheiro">Dinheiro</option>
                                  <option value="Deposito">Deposito</option>
                                  <option value="Cheque">Cheque</option>
                              </select>
                              </td>
                          <td>
                              <select class="form-select campoInput" id="ContaSelect" name="ContaSelect" style="display: none;">
                                  <optgroup label="Conta bancária Deposito"></optgroup>
                                   <option value=""></option>
                                  <option value="341">341 - Itaú</option>
                                  <option value="077">077 - Banco Inter</option>
                              </select>
                              
                            <select class="form-select campoInput" id="chbanco" name="chbanco" style="display: none;">
                                  <optgroup label="Conta bancária Cheque"></optgroup>
                                   <option value=""></option>
                                  <option value="0341">341 - Itaú</option>
                                  <option value="0077">077 - Banco Inter</option>
                              </select>
                              <input type="text" class="form-control campoInput" id="chagencia" name="chagencia" value="" placeholder="Agencia"  style="display: none;">
                              <input type="text" class="form-control campoInput" id="chconta" name="chconta" value="" placeholder="Conta"  style="display: none;">
                              <input type="text" class="form-control campoInput" id="chdoc" name="chdoc" value="" placeholder="Documento" oninput="formatarNumero(this);"  style="display: none;">
                              </td>
                          <td></td>
                        </tr>
                     </tbody>
                    </table>
                  </div>
                </div>

                  <table class="table mb-0 fs--1 border-200 overflow-hidden" id="BodyTable">
                      <thead class="bg-light text-900 font-sans-serif">
                        <tr>
                          <th style="width: 0.01%;" class="small-width"></th>
                          <th class="col-sm-2 frame-recebimento-col-data"><center>Total</center></th>
                          <th class="col-sm-2" id="str_frame_pagamento_valor"><center><span id="total">R$ 0,00</span></center></th>
                          <th class="col-sm-2" style=""></th>
                          <th class="fr-hide-simplificado pe-12 py-3" data-sort="status"></th>
                          <th style="width: 0.01%;" class="small-width"></th>
                        </tr>
                      </thead>
                      </table>

              </div>
            </div>
            <div class="col-auto">
                <button class="btn btn-link" type="button" id="pag_aNovaLinhaParcela" onclick="adicionarLinhaParcela();"><i class="fa fa-plus-circle"></i> Adicionar outra parcela</button>
            </div>
            
            <script>
            
                function validarCampos() {
                    let data = document.getElementById("data").value;
                    let forma = document.getElementById("forma").value;
                    let valor = document.getElementById("valor").value;
                    let conta = document.getElementById("ContaSelect").value;
                    let chbanco = document.getElementById("chbanco").value;
                    let chagencia = document.getElementById("chagencia").value;
                    let chconta = document.getElementById("chconta").value;
                    let chdoc = document.getElementById("chdoc").value;
                
                    if (data === "" || forma === "" || valor === "") {
                        alert("Preencha todos os campos antes de adicionar uma linha.");
                        return false;
                    }
                    
                    if (forma === "Deposito" && conta === "") {
                        alert("Preencha todos os campos antes de adicionar uma linha.");
                        return false;
                    }
                    
                     if (forma === "Cheque" && (chbanco === "" || chagencia === "" || chconta === "" || chdoc === "")) {
                        alert("Preencha todos os campos antes de adicionar uma linha.");
                        return false;
                    }
                    
                    if (data.length < 10 || (forma === "Cheque" && chdoc > 14)){
                    alert("Preencha todos os campos por completo antes de adicionar uma linha.");
                    return false;
                    }
                
                    return true;
                }
                
                let rowIndex = 1; // Índice inicial de linha
                let total = 0;
                function adicionarLinhaParcela() {
                        if (!validarCampos()) {
                            return; // Impede a adição de linha se os campos não estiverem preenchidos
                        }
                
                const table = document.getElementById("BodyTable"); // Correção no ID
                
                let data = document.getElementById("data").value;
                let forma = document.getElementById("forma").value;
                let conta = document.getElementById("ContaSelect").value;
                let valorInput = document.getElementById("valor");
                let valor = parseFloat(valorInput.value.replace(/[^\d,]/g, '').replace(',', '.')); // Extrai e converte o valor
                let chbanco = document.getElementById("chbanco").value;
                let chagencia = document.getElementById("chagencia").value;
                let chconta = document.getElementById("chconta").value;
                let chdoc = document.getElementById("chdoc").value;
               
    
                total += valor;
                document.getElementById("total").textContent ='R$ '+total.toFixed(2);


                const newRow = table.insertRow(); // Insere uma nova linha
                let indexCell = newRow.insertCell(0);
                let cell1 = newRow.insertCell(1);
                let cell2 = newRow.insertCell(2);
                let cell3 = newRow.insertCell(3);
                let detalhes = newRow.insertCell(4);
                let deleteCell = newRow.insertCell(5);

            
                indexCell.innerHTML = rowIndex++; // Incrementa e insere o índice
                cell1.innerHTML = '<center>'+data+'</center>';
                cell2.innerHTML = '<center>R$ '+valor.toFixed(2)+'</center>';
                cell3.innerHTML = '<center>'+forma+'</center>';
                 if (forma === "Deposito") {detalhes.innerHTML = conta;}
                 if (forma === "Cheque") {detalhes.innerHTML = '<center>Banco: '+chbanco+' / Ag: '+chagencia+' / Conta: '+chconta+'<br> Documento: '+chdoc+'</center>';}
                
                deleteCell.innerHTML = '<button class="btn btn-falcon-default btn-sm" type="button" onclick="deletarLinha(this, '+valor+')"><span class="far fa-trash-alt"></span></button>';
                
                    document.getElementById("data").focus();
                  
                    document.getElementById("valor").value = "";
                    document.getElementById("data").value = "";
                    document.getElementById("chdoc").value = "";
                    document.getElementById("chconta").value = "";
                    document.getElementById("chagencia").value = "";
                    document.getElementById("chbanco").value = "";
                    
                    document.getElementById("ContaSelect").value = "";
                    
                    document.getElementById("forma").value = "";

                return newRow;
              }
              
              function deletarLinha(button, valor) {
                let row = button.parentNode.parentNode;
                row.parentNode.removeChild(row);
                atualizarIndices(); // Chama a função para atualizar os índices
                
                total -= valor;
                document.getElementById("total").textContent = 'R$ '+total.toFixed(2);
              }
            
              function atualizarIndices() {
                let tabela = document.getElementById("BodyTable");
                let rows = tabela.getElementsByTagName("tr");
                let rowIndex = 1;
                
                for (let i = 1; i < rows.length; i++) {
                  rows[i].cells[0].innerHTML = i; // Atualiza o índice
                }
            
                if (rows.length === 1) {
                  rowIndex = 0; // Se não houver mais linhas, redefine o índice
                } else {
                  rowIndex = rows.length - 1; // Atualiza o índice global
                }
              }
              
                const formaSelect = document.getElementById("forma");
                formaSelect.addEventListener("change", function() {
                const selectedValue = formaSelect.value;
                
                let ContaSelect = document.getElementById("ContaSelect");
                let chbanco = document.getElementById("chbanco");
                let chagencia = document.getElementById("chagencia");
                let chconta = document.getElementById("chconta");
                let chdoc = document.getElementById("chdoc");
                
                if (selectedValue === "" || selectedValue === "Dinheiro") {
                    ContaSelect.style.display = "none";
                    chbanco.style.display = "none";
                    chagencia.style.display = "none";
                    chconta.style.display = "none";
                    chdoc.style.display = "none";
                }
                if (selectedValue === "Deposito") {
                    ContaSelect.style.display = "block";
                    chbanco.style.display = "none";
                    chagencia.style.display = "none";
                    chconta.style.display = "none";
                    chdoc.style.display = "none";
                } 
                if  (selectedValue === "Cheque") {
                    ContaSelect.style.display = "none";
                    chbanco.style.display = "block";
                    chagencia.style.display = "block";
                    chconta.style.display = "block";
                    chdoc.style.display = "block";
                }

            });
              
              // Função para formatar a data com barras (/) automaticamente
            // Event listener para o campo de data
            document.getElementById("data").addEventListener("input", function() {
                formatarDataInput(this);
            });
            
            function formatarDataInput(input) {
                let value = input.value.replace(/\D/g, ''); // Remove todos os caracteres não numéricos
                if (value.length > 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2);
                }
                if (value.length > 5) {
                    value = value.slice(0, 5) + '/' + value.slice(5, 9);
                }
                input.value = value;
            }

            // Função para formatar valor automaticamente
             // Event listener para o campo de valor
            document.getElementById("valor").addEventListener("input", function() {
                this.value = formatarValor(this.value);
            });
            
            function formatarValor(value) {
                // Remove todos os caracteres não numéricos e a vírgula
                let numericValue = value.replace(/[^\d]/g, "");
                
                if (numericValue === "" || numericValue === "0") {
                return "0,00";
                    }
                
                // Divide o valor em duas partes: parte inteira e parte decimal
                let parteInteira = numericValue.slice(0, -2);
                let parteDecimal = numericValue.slice(-2);
                
                // Formata o valor com vírgula
                let valorFormatado = parteInteira + "," + parteDecimal;
                
                return valorFormatado;
            }
            
             // Função para formatar doc automaticamente
             function formatarNumero(input) {
                let value = input.value.replace(/\D/g, ''); // Remove caracteres não numéricos
    
                if (value.length > 11) {
                    input.setAttribute('maxlength', '18');
                    input.setAttribute('pattern', '\\d{2}.\\d{3}.\\d{3}/\\d{4}-\\d{2}');
                    input.value = value.replace(/^(\d{2})(\d{3})(\d{3})(\d{4})(\d{2}).*/, '$1.$2.$3/$4-$5');
                } else {
                    input.setAttribute('maxlength', '14');
                    input.setAttribute('pattern', '\\d{3}.\\d{3}.\\d{3}-\\d{2}');
                    input.value = value.replace(/^(\d{3})(\d{3})(\d{3})(\d{2}).*/, '$1.$2.$3-$4');
                }
            }
            
            /*const camposInput = document.querySelectorAll(".campoInput");
                    camposInput.forEach(function(campo) {
                        campo.addEventListener("keyup", function(event) {
                            if (event.key === "Enter") {
                               adicionarLinhaParcela();
                            }
                        });
                    });*/

                          
           </script>
              

       
            </div>

        <!-- ===============================================-->
        <!--    End of page-->
        <!-- ===============================================-->

        <?php require_once('footer.php'); ?>
        
      </div>
    </div>
  </main>
  <!-- ===============================================-->
  <!--    End of Main Content-->
  <!-- ===============================================-->


  <!-- ===============================================-->
  <!--    JavaScripts-->
  <!-- ===============================================-->
  <script src="vendors/popper/popper.min.js"></script>
  <script src="vendors/bootstrap/bootstrap.min.js"></script>
  <script src="vendors/anchorjs/anchor.min.js"></script>
  <script src="vendors/is/is.min.js"></script>
  <script src="vendors/fontawesome/all.min.js"></script>
  <script src="vendors/lodash/lodash.min.js"></script>
  <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
  <script src="vendors/list.js/list.min.js"></script>
  <script src="assets/js/theme.js"></script>
  <script src="vendors/dropzone/dropzone.min.js"></script>

</body>

</html>