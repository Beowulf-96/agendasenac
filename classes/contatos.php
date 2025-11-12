<?php

require_once 'conexao.php';

class Contato {
    private $id;
    private $nome;
    private $endereco;
    private $email;
    private $telefone;
    private $redeSocial;
    private $profissao;
    private $dataNasc;
    private $foto;
    private $ativo;

    private $con;

    public function __construct() {
        $this->con = new Conexao();
    }

    private function existeEmail($email) {
        $sql = $this->con->conectar()->prepare("SELECT id FROM contatos WHERE email = :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        if($sql->rowCount() > 0) {
            $array = $sql->fetch(); //fetch retorna o email enccontrado
        }else{
            $array = array();
        }
        return $array;
    }

    public function adicionar($email, $nome, $endereco, $telefone, $redeSocial, $profissao, $dataNasc, $foto, $ativo) {
    echo "Método adicionar chamado<br>";
    echo "Email: $email<br>";
    
    $emailExistente = $this->existeEmail($email);
    echo "Email existente: ";
    var_dump($emailExistente);
    echo "<br>";
    
    if(count($emailExistente) == 0) {
        try{
            echo "Preparando para inserir...<br>";
            
            $this->nome = $nome;
            $this->endereco = $endereco;
            $this->email = $email;
            $this->telefone = $telefone;
            $this->redeSocial = $redeSocial;
            $this->profissao = $profissao;
            $this->dataNasc = $dataNasc;
            $this->foto = ''; // Campo foto vazio na tabela contatos
            $this->ativo = $ativo;
            
            // INSERT incluindo o campo foto
            $sql = $this->con->conectar()->prepare("INSERT INTO contatos (nome, endereco, email, telefone, redeSocial, profissao, dataNasc, foto, ativo) VALUES (:nome, :endereco, :email, :telefone, :redeSocial, :profissao, :dataNasc, :foto, :ativo)");
            $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
            $sql->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
            $sql->bindParam(":email", $this->email, PDO::PARAM_STR);
            $sql->bindParam(":telefone", $this->telefone, PDO::PARAM_STR);
            $sql->bindParam(":redeSocial", $this->redeSocial, PDO::PARAM_STR);
            $sql->bindParam(":profissao", $this->profissao, PDO::PARAM_STR);
            $sql->bindParam(":dataNasc", $this->dataNasc, PDO::PARAM_STR);
            $sql->bindParam(":foto", $this->foto, PDO::PARAM_STR);
            $sql->bindParam(":ativo", $this->ativo, PDO::PARAM_STR);
            
            $executou = $sql->execute();
            echo "Execute retornou: ";
            var_dump($executou);
            echo "<br>";
            
            if(!$executou) {
                echo "Erro no SQL: ";
                print_r($sql->errorInfo());
                echo "<br>";
                return FALSE;
            }
            
            // Pegar o ID do contato recém-criado
            $id = $this->con->conectar()->lastInsertId();
            echo "ID inserido: $id<br>";
            
            // Inserir imagens se houver
            if(isset($foto['tmp_name']) && count($foto['tmp_name']) > 0 && !empty($foto['tmp_name'][0])) {
                echo "Processando fotos...<br>";
                
                // Verificar se o diretório existe
                if(!is_dir('image/contatos/')) {
                    mkdir('image/contatos/', 0777, true);
                    echo "Diretório criado<br>";
                }
                
                for ($q=0; $q<count($foto['tmp_name']); $q++) {
                    if(!empty($foto['tmp_name'][$q])) {
                        $tipo = $foto['type'][$q];
                        echo "Processando foto $q - Tipo: $tipo<br>";
                        
                        if(in_array($tipo, array('image/jpeg', 'image/png', 'image/jpg'))){
                            $tmpname = md5(time().rand(0, 9999)).'.jpg';
                            
                            if(move_uploaded_file($foto['tmp_name'][$q], 'image/contatos/'.$tmpname)) {
                                echo "Arquivo movido com sucesso: $tmpname<br>";
                                
                                list($width_orig, $height_orig) = getimagesize('image/contatos/'.$tmpname);
                                $ratio = $width_orig/$height_orig;
                                $width = 500;
                                $height = 500;
                                
                                if($width/$height > $ratio) {
                                    $width = $height * $ratio;
                                } else {
                                    $height = $width/$ratio;
                                }
                                
                                $img = imagecreatetruecolor($width, $height);
                                
                                if($tipo == 'image/jpeg' || $tipo == 'image/jpg') {
                                    $origi = imagecreatefromjpeg('image/contatos/'. $tmpname);
                                } elseif ($tipo == 'image/png') {
                                    $origi = imagecreatefrompng('image/contatos/' .$tmpname);
                                }
                                
                                imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);
                                
                                // Salvar imagem no servidor
                                imagejpeg($img, 'image/contatos/'.$tmpname, 80);
                                
                                // Salvar a URL da foto no banco
                                $sqlFoto = $this->con->conectar()->prepare("INSERT INTO foto_contato SET id_contato = :id_contato, url = :url");
                                $sqlFoto->bindValue(":id_contato", $id);
                                $sqlFoto->bindValue(":url", $tmpname);
                                $sqlFoto->execute();
                                
                                echo "Foto salva no banco: $tmpname<br>";
                            } else {
                                echo "Erro ao mover arquivo<br>";
                            }
                        } else {
                            echo "Tipo de arquivo não permitido: $tipo<br>";
                        }
                    }
                }
            } else {
                echo "Nenhuma foto para processar<br>";
            }
            
            return TRUE;

        }catch(PDOException $ex) {
            echo 'ERRO PDO: ' . $ex->getMessage() . "<br>";
            return 'ERRO: ' . $ex->getMessage();
        }
    }else{
        echo "Email já existe no banco<br>";
        return FALSE;
    }
}

    public function listar() {
        try {
          $sql = $this->con->conectar()->prepare("SELECT * FROM contatos");
          $sql->execute();
          return $sql->fetchALL();

        }catch(PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage();

        }

    }

    public function getFoto() {
        $array = array();
        $sql= $this->con->conectar()->prepare("SELECT *,
        (select foto_contato.url from foto_contato where foto_contato.id_contato = contatos.id limit 1) as url FROM contatos");
        $sql->execute();
        if($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }
        return $array;
    }

    public function buscar($id) {
        try{
            $sql = $this->con->conectar()->prepare(" SELECT * FROM contatos WHERE id = :id ");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql->rowCount() > 0) {
                return $sql->fetch();
            }else{
                return array();
            }
        }catch(PDOException $ex) {
            echo 'ERRO: ' . $ex->getMessage();

        }

    }

    public function editar($id, $nome, $endereco, $email, $telefone, $redeSocial, $profissao, $dataNasc, $foto, $ativo) {
            $emailExistente = $this->existeEmail($email);
            if (count($emailExistente) > 0 && $emailExistente['id'] != $id) {
                return FALSE;
            } else {
                try{
                    $sql = $this->con->conectar()->prepare("UPDATE contatos SET nome = :nome, endereco = :endereco, email = :email, telefone = :telefone, redeSocial = :redeSocial, profissao = :profissao, dataNasc = :dataNasc, ativo = :ativo WHERE id = :id");
                    $sql->bindValue(":nome", $nome);
                    $sql->bindValue(":endereco", $endereco);
                    $sql->bindValue(":email", $email);
                    $sql->bindValue(":telefone", $telefone);
                    $sql->bindValue(":redeSocial", $redeSocial);
                    $sql->bindValue(":profissao", $profissao);
                    $sql->bindValue(":dataNasc", $dataNasc);
                    //$sql->bindValue(":foto", $foto);
                    $sql->bindValue(":ativo", $ativo);
                    $sql->bindValue(":id", $id);
                    $sql->execute();

                    //inserir imagem se houver
                if(count($foto) > 0) {
                    for ($q=0; $q<count($foto['tmp_name']); $q++) {
                        $tipo = $foto['type'][$q];
                        if(in_array($tipo, array('image/jpeg', 'image/png'))){
                            $tmpname = md5(time().rand(0, 9999)).'.jpg';
                            move_uploaded_file($foto['tmp_name'][$q], 'image/contatos/'.$tmpname);
                            list($width_orig, $height_orig) = getimagesize('image/contatos/'.$tmpname);
                            $ratio = $width_orig/$height_orig;
                            $width = 500;
                            $height = 500;
                            if($width/$height > $ratio) {
                                $width = $height * $ratio;
                            } else {
                                $height = $width/$ratio;
                            }
                            $img = imagecreatetruecolor($width, $height);
                            if($tipo == 'image/jpeg') {
                                $origi = imagecreatefromjpeg('image/contatos/'. $tmpname);
                            } elseif ($tipo == 'image/png') {
                                $origi = imagecreatefrompng('image/contatos/' .$tmpname);
                            }
                            imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                            //salvar imagens servidor

                            imagejpeg($img, 'image/contatos/'.$tmpname, 80);

                            //Salvar a url da foto no hd
                            $sql = $this->con->conectar()->prepare("INSERT INTO foto_contato SET id_contato = :id_contato, url = :url");
                            $sql->bindValue(":id_contato", $id);
                            $sql->bindValue(":url", $tmpname);
                            $sql->execute();
                        }
                }
            }
                return TRUE;
                
                } catch(PDOException $ex) {
                    echo "Erro: ".$ex->getMessage();
                }
            }
        }
        public function deletar($id) {
        $sql =$this->con->conectar()->prepare("DELETE FROM contatos WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        }

        public function deletarFoto($id) {
        $sql =$this->con->conectar()->prepare("DELETE FROM foto_contato WHERE id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();
        }
        
        public function getContato($id) {
            $array = array();
            $sql = $this->con->conectar()->prepare("SELECT * FROM contatos WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            if($sql->rowCount() > 0){
                $array = $sql->fetch();
                //mostrar todas as imagens cadastradas
                $array['foto'] = array();
                $sql = $this->con->conectar()->prepare("SELECT id, url FROM foto_contato WHERE id_contato = :id_contato");
                $sql->bindValue(":id_contato", $id);
                $sql->execute();
                if($sql->rowCount() > 0) {
                    $array['foto'] = $sql->fetchAll();
                }
            }
            return $array;
        }
    }