<!DOCTYPE html>
<html data-bs-theme="light" lang="pt-BR" dir="ltr">

<?php 

/*require_once('session-lgin.php');*/
require_once ('pdoconfig.php');
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        //echo "Conectado a $dbname em $host com sucesso.";
        } catch (PDOException $pe) {
        die("Não foi possível se conectar ao banco de dados $dbname :" . $pe>getMessage());
        exit();
        }
 require_once('header.php'); 
 require_once('functions.php');
 
 function tagValue($node,$tag){
    return $node->getElementsByTagName("$tag")->item(0)->nodeValue;
}
 
 ?>


<body>

  <!-- ===============================================-->
  <!--    Main Content-->
  <!-- ===============================================-->
  <main class="main" id="top">
    <div class="container" data-layout="container">
      <script>
        var isFluid = JSON.parse(localStorage.getItem('isFluid'));
        if (isFluid) {
          var container = document.querySelector('[data-layout]');
          container.classList.remove('container');
          container.classList.add('container-fluid');
        }
      </script>

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
            <h5 class="mb-0 text-primary position-relative"><span class="bg-200 dark__bg-1100 pe-3">Assistante de Importação XML</span><span
                class="border position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span></h5>
            <p class="mb-0">Carregar arquivos...</p>
          </div>
        </div>

       <?php 
       
           // Pasta onde o arquivo vai ser salvo
            $_UP['pasta'] = 'uploads/xml_industria/';
             
            // Tamanho máximo do arquivo (em Bytes)
            $_UP['tamanho'] = 1024 * 500; // 500Kb
             
            // Array com as extensões permitidas
            $_UP['extensoes'] = array('xml');
             
            // Renomeia o arquivo? (Se true, o arquivo será salvo como .xml e um nome único)
            $_UP['renomeia'] = true;
             
            // Array com os tipos de erros de upload do PHP
            $_UP['erros'][0] = 'Não houve erro';
            $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
            $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
            $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
            $_UP['erros'][4] = 'Não foi feito o upload do arquivo';
            
            $extensao = strtolower(end(explode('.', $_FILES['file']['name'])));
            $file_check = explode('.', $_FILES['file']['name']);
             
            // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
            if ($_FILES['arquivo']['error'] != 0) {
            die("Não foi possível fazer o upload, erro:<br />" . $_UP['erros'][$_FILES['arquivo']['error']]);
            exit; // Para a execução do script
            }
            // Faz a verificação da extensão do arquivo
            //elseif (array_search($extensao, $_UP['extensoes']) === false) {
            elseif($file_check[sizeof($file_check)-1] != 'xml'){
                echo "Por favor, envie arquivos com as seguintes extensões: xml";
            }
            // Faz a verificação do tamanho do arquivo
            elseif ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
                echo "O arquivo enviado é muito grande, envie arquivos de até 500Kb.";
            }
            // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
            else {

                    /*if(move_uploaded_file($_FILES['file']['tmp_name'],  $_UP['pasta'].$_FILES['file']['name'])) {*/
                    
                        // Executa o código para processar o arquivo:
                        
                        $docxml = file_get_contents($_FILES['file']['name']);
                        
                        $doc = new DOMDocument();
                        $doc->preservWhiteSpace = FALSE; //elimina espacos em branco
                        $doc->formatOutput = FALSE;
                        $doc->loadXML($docxml,LIBXML_NOBLANKS | LIBXML_NOEMPTYTAG);
                        
                        $infNFe=$doc->getElementsByTagName('infNFe')->item(0);
                            //obtem a versaoo do layout da NFe
                            $dados_xml['versao']=trim($infNFe->getAttribute("versao"));
                            $dados_xml['chave']= substr(trim($infNFe->getAttribute("Id")),3);
                        
                        // Reconhecimento dos campos do XML
                        $ide=$doc->getElementsByTagName('ide')->item(0);
                            $dados_xml['dataEmissao']=tagValue($ide,"dhEmi");
                            $dados_xml['dataMovimento']=tagValue($ide,"dSaiEnt")." ".tagValue($doc,"hSaiEnt");
                            $dados_xml['codigonf']=tagValue($ide,"cNF");
                            $dados_xml['natureza']=tagValue($ide,"natOp");
                            $dados_xml['numero']=tagValue($ide,"nNF");
                            $dados_xml['modelo']=tagValue($ide,"mod");
                            $dados_xml['serie']=tagValue($ide,"serie");
                    
                        // Emitente:
                        $emi=$doc->getElementsByTagName('emit')->item(0);
                            $c1=tagValue($emi,"CNPJ");
                            $c2=substr($c1,0,2).".".substr($c1,2,3).".".substr($c1,5,3)."/".substr($c1,8,4)."-".substr($c1,12,2);
                            $dados_xml['emitenteCnpj']=$c1;
                            $dados_xml['emitenteCnpjFormatado']=$c2;
                            $dados_xml['emitenteRazaoSocial']=tagValue($emi,"xNome");
                            $dados_xml['emitenteNome']=tagValue($emi,"xFant");
                            $dados_xml['emitenteInscricaoEstadual']=tagValue($emi,"IE");
                            $dados_xml['emitenteInscricaoMunicipal']=tagValue($emi,"IM");
                            $dados_xml['emitenteCnae']=tagValue($emi,"CNAE");
                            $dados_xml['emitenteEndereco']=tagValue($emi,"xLgr");
                            $dados_xml['emitenteNumero']=tagValue($emi,"nro");
                            $dados_xml['emitenteBairro']=tagValue($emi,"xBairro");
                            $dados_xml['emitenteMunicipio']=tagValue($emi,"xMun");
                            $dados_xml['emitenteMunicipioIbge']=tagValue($emi,"cMun");
                            $dados_xml['emitenteCep']=tagValue($emi,"CEP");
                            $dados_xml['emitenteUF']=tagValue($emi,"UF");
                            $dados_xml['emitentePaisIbge']=tagValue($emi,"cPais");
                            $dados_xml['emitentePais']=tagValue($emi,"xPais");
                            $dados_xml['emitenteTelefone']=tagValue($emi,"fone");
                    
                        // Destinatário:
                        $dst=$doc->getElementsByTagName('dest')->item(0);
                            $cnpj1=tagValue($dst,"CNPJ");
                            $cpf1=tagValue($dst,"CPF");
                            $cnpj2=substr($cnpj1,0,2).".".substr($cnpj1,2,3).".".substr($cnpj1,5,3)."/".substr($cnpj1,8,4)."-".substr($cnpj1,12,2);
                            $cpf2=substr($cpf1,0,3).".".substr($cpf1,3,3).".".substr($cpf1,6,3)."-".substr($cpf1,9,2);
                            $dados_xml['destinatarioCnpj']=$cnpj1;
                            $dados_xml['destinatarioCnpjFormatado']=$cnpj2;
                            $dados_xml['destinatarioCpf']=$cpf1;
                            $dados_xml['destinatarioCpfFormatado']=$cpf2;
                            $dados_xml['destinatarioRazaoSocial']=tagValue($dst,"xNome");
                            $dados_xml['destinatarioNome']=tagValue($dst,"xFant");
                            $dados_xml['destinatarioInscricaoEstadual']=tagValue($dst,"IE");
                            $dados_xml['destinatarioInscricaoMunicipal']=tagValue($dst,"IM");
                            $dados_xml['destinatarioEndereco']=tagValue($dst,"xLgr");
                            $dados_xml['destinatarioNumero']=tagValue($dst,"nro");
                            $dados_xml['destinatarioBairro']=tagValue($dst,"xBairro");
                            $dados_xml['destinatarioMunicipio']=tagValue($dst,"xMun");
                            $dados_xml['destinatarioMunicipioIbge']=tagValue($dst,"cMun");
                            $dados_xml['destinatarioCep']=tagValue($dst,"CEP");
                            $dados_xml['destinatarioUF']=tagValue($dst,"UF");
                            $dados_xml['destinatarioPaisIbge']=tagValue($dst,"cPais");
                            $dados_xml['destinatarioPais']=tagValue($dst,"xPais");
                            $dados_xml['destinatarioTelefone']=tagValue($dst,"fone");
                            $dados_xml['destinatarioEmail']=tagValue($dst,"email");
                    
                            $dados_xml['pesoLiquido']=floatval(tagValue($doc,"pesoL"));
                            $dados_xml['pesoBruto']=floatval(tagValue($doc,"pesoB"));
                    
                            $dados_xml['dataRecibo']=tagValue($doc,"dhRecbto");
                            $dados_xml['protocolo']=tagValue($doc,"nProt");
                    
                    
                        // Totais da NF-e. Para fazer a alimentação no database referente aos calculos e paineis:
                        $total=$doc->getElementsByTagName('ICMSTot')->item(0);
                            $dados_xml['basecalculo']=tagValue($total,"vBC");
                            $dados_xml['valoricms']=tagValue($total,"vICMS");
                            $dados_xml['valorbcst']=tagValue($total,"vBCST");
                            $dados_xml['valorst']=tagValue($total,"vST");
                            $dados_xml['totalprodutos']=tagValue($total,"vProd");
                            $dados_xml['valorfrete']=tagValue($total,"vFrete");
                            $dados_xml['valorseguro']=tagValue($total,"vSeg");
                            $dados_xml['valordesconto']=tagValue($total,"vDesc");
                            $dados_xml['valorii']=tagValue($total,"vII");
                            $dados_xml['valoripi']=tagValue($total,"vIPI");
                            $dados_xml['valorpis']=tagValue($total,"vPIS");
                            $dados_xml['valorcofins']=tagValue($total,"vCOFINS");
                            $dados_xml['valoroutro']=tagValue($total,"vOutro");
                            $dados_xml['valortotalnf']=tagValue($total,"vNF");
                            
                        // Totais da NF-e. Para fazer a alimentação no database referente aos calculos e paineis:
                        $infAdic=$doc->getElementsByTagName('infAdic')->item(0);
                            $dados_xml['infCpl']=tagValue($infAdic,"infCpl");
                            
                        $temerro = 0;
                        // Create connection   
                        $conn_egestor = new mysqli($host, $username, $password, $dbname);
                        // Check connection
                        if ($conn_egestor->connect_error) {
                          die("Falha na conexão: " . $conn_egestor->connect_error);
                        }
                        
                        // Turn autocommit off
                        $conn_egestor -> autocommit(FALSE);
                        
                        $docfsc = $cnpj1;
                        if($cnpj1 == null){$docfsc = $cpf1;}
                        
                        // Primeiro verifica se deve trocar o nome do arquivo
                        if ($_UP['renomeia'] == true) {
                        // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .xml
                        $nome_final = $dados_xml['chave'].'-nfe.xml';
                        
                        rename($_UP['pasta'].$_FILES['file']['name'], $_UP['pasta'].$arquivo_novo);
                        } else {
                        // Mantém o nome original do arquivo
                        $nome_final = $_FILES['arquivo']['name'];
                        }
                        
                                
                        //INSERÇÃO DE DADOS NO MYSQL:
                        $sql_NF="INSERT INTO eg_cad_xmlNF (cNF, versao, chNFe, natureza_operacao, serie, nNF, data_emissao, cnpj_emit, cnpj_dest, xNome, xFant, IE, IM, xLgr, nro, xBairro, xMun, cMun, CEP, UF, cPais, xPais, fone, email_dest, valor_base_calculo, valor_icms, valor_base_subst_trib, valor_subst_trib, valor_produtos, valor_frete, valor_seguro, valor_desconto, valor_ii, valor_ipi, valor_pis, valor_cofins, valor_outro, valor_nf, infCpl, xmlArquivo, data_inclusao_nf) 
                           VALUES ('".$dados_xml['codigonf']."', '".$dados_xml['versao']."', '".$dados_xml['chave']."', '".$dados_xml['natureza']."', '".$dados_xml['serie']."', '".$dados_xml['numero']."', '".$dados_xml['dataEmissao']."', 
                            '".$dados_xml['emitenteCnpj']."', '".$docfsc."', '".$dados_xml['destinatarioRazaoSocial']."', '".$dados_xml['destinatarioNome']."', '".$dados_xml['destinatarioInscricaoEstadual']."', '".$dados_xml['destinatarioInscricaoMunicipal']."', '".$dados_xml['destinatarioEndereco']."', '".$dados_xml['destinatarioNumero']."', '".$dados_xml['destinatarioBairro']."', '".$dados_xml['destinatarioMunicipio']."', '".$dados_xml['destinatarioMunicipioIbge']."', '".$dados_xml['destinatarioCep']."', '".$dados_xml['destinatarioUF']."', '".$dados_xml['destinatarioPaisIbge']."', '".$dados_xml['destinatarioPais']."', '".$dados_xml['destinatarioTelefone']."', '".$dados_xml['destinatarioEmail']."', '".$dados_xml['basecalculo']."', '".$dados_xml['valoricms']."', '".$dados_xml['valorbcst']."', '".$dados_xml['valorst']."', '".$dados_xml['totalprodutos']."', '".$dados_xml['valorfrete']."', '".$dados_xml['valorseguro']."', '".$dados_xml['valordesconto']."', '".$dados_xml['valorii']."', '".$dados_xml['valoripi']."', '".$dados_xml['valorpis']."', '".$dados_xml['valorcofins']."', '".$dados_xml['valoroutro']."', '".$dados_xml['valortotalnf']."', '".$dados_xml['infCpl']."', '".$nome_final."', '".date("Y-m-d H:i:s")."')";
                          
                        try{ 
                            if($conn_egestor->query($sql_NF) === TRUE) {
                                
                                // Tag det dos itens unitários:
                                $det=$doc->getElementsByTagName('det');
                                    for ($i = 0; $i < $det->length; $i++) {
                                        $nItem=$det->item($i);
                                        $item['cProd']=tagValue($nItem,"cProd");
                                        $item['cEAN']=tagValue($nItem,"cEAN");
                                        $item['cBarra']=tagValue($nItem,"cBarra");
                                        $item['xProd']=tagValue($nItem,"xProd");
                                        $item['NCM']=tagValue($nItem,"NCM");
                                        $item['CEST']=tagValue($nItem,"CEST");
                                        $item['indEscala']=tagValue($nItem,"indEscala");
                                        $item['CFOP']=tagValue($nItem,"CFOP");
                                        $item['uCom']=tagValue($nItem,"uCom");
                                        $item['qCom']=tagValue($nItem,"qCom");
                                        $item['vUnCom']=tagValue($nItem,"vUnCom");
                                        $item['vProd']=tagValue($nItem,"vProd");
                                        $item['cEANTrib']=tagValue($nItem,"cEANTrib");
                                        $item['cBarraTrib']=tagValue($nItem,"cBarraTrib");
                                        $item['uTrib']=tagValue($nItem,"uTrib");
                                        $item['qTrib']=tagValue($nItem,"qTrib");
                                        $item['vUnTrib']=tagValue($nItem,"vUnTrib");
                                        $item['indTot']=tagValue($nItem,"indTot");
                                        $item['xPed']=tagValue($nItem,"xPed");
                                        $item['nItemPed']=tagValue($nItem,"nItemPed");
                                        $item['nLote']=tagValue($nItem,"nLote");
                                        $item['qLote']=tagValue($nItem,"qLote");
                                        $item['dFab']=tagValue($nItem,"dFab");
                                        $item['dVal']=tagValue($nItem,"dVal");
                                        $item['cAgreg']=tagValue($nItem,"cAgreg");
                                        
                                        $sql_Prods="INSERT INTO eg_cad_xmlProds (chNFe, cnpj_emit, nNFe, cProd, cEAN, cBarra, xProd, NCM, CEST, indEscala, CFOP, uCom, qCom, vUnCom, vProd, cEANTrib, cBarraTrib, uTrib, qTrib, vUnTrib, indTot, xPed, nItemPed, nLote, qLote, dFab, dVal, cAgreg) VALUES ('".$dados_xml['chave']."', '".$dados_xml['emitenteCnpj']."', '".$dados_xml['numero']."', '".$item['cProd']."', '".$item['cEAN']."', '".$item['cBarra']."', '".$item['xProd']."', '".$item['NCM']."', '".$item['CEST']."', '".$item['indEscala']."', '".$item['CFOP']."', '".$item['uCom']."', '".$item['qCom']."', '".$item['vUnCom']."', '".$item['vProd']."', '".$item['cEANTrib']."', '".$item['cBarraTrib']."', '".$item['uTrib']."', '".$item['qTrib']."', '".$item['vUnTrib']."', '".$item['indTot']."', '".$item['xPed']."', '".$item['nItemPed']."', '".$item['nLote']."', '".$item['qLote']."', '".$item['dFab']."', '".$item['dVal']."', '".$item['cAgreg']."')";
                                        try{
                                            if($conn_egestor->query($sql_Prods)  === TRUE){}
                                        }catch (Exception $e) {
                                            $temerro = 1;
                                        }
                                    }
                            }
                        }catch (Exception $e) {
                            $temerro = 1;
                           Echo '<div class="alert alert-danger border-2 d-flex align-items-center" role="alert">
                                    <div class="bg-danger me-3 icon-item"><span class="fas fa-times-circle text-white fs-3"></span></div>
                                     <p class="mb-0 flex-1"><strong>Erro ao processar inserção de dados...</strong> <br /><br /> '.$sql_NF.' <br /><br /> Exceção capturada: '.$e->getMessage().'</p>
                                     <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                        }
                        
                        if($temerro != 0){
                            $conn_egestor->rollback();
                        }
                        else{
                            $conn_egestor->commit();
                            Echo '<div class="alert alert-success border-2 d-flex align-items-center" role="alert">
                                    <div class="bg-success me-3 icon-item"><span class="fas fa-check-circle text-white fs-3"></span></div>
                                     <p class="mb-0 flex-1">NF '.$dados_xml["numero"].' inserida com sucesso!</p>
                                     <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>';
                            echo "<meta HTTP-EQUIV='Refresh' CONTENT='1;URL=invoice-list.php'>";
                        }
                        
                        $conn_egestor->close();
                /*}*/
            }
         
       ?>
       

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