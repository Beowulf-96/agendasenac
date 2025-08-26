<?php

require_once 'conexao.php';

class Contato {
    private $id;
    private $nome;
    private $endereco;
    private $email;
    private $telefone;
    private $redesocial;
    private $profissao;
    private $datanasc;
    private $foto;
    private $ativo;

    private $con;

    public function __construct() {
        $this->con = new Conexao();
    }

    private function existeEmail($email) {
        $sql = $this->con->conectar()->prepare("SELECT id_contato FROM contatos WHERE email = :email");
        $sql->bindParam(':email', $email, PDO::PARAM_STR);
        $sql->execute();

        if($sql->rowCOunt() > 0) {
            $array = $sql->fetch(); //fetch retorna o email enccontrado
        }else{
            $array = array();
        }
        return $array;
    }

    public function adicionar($email, $nome, $endereco, $telefone, $redesocial, $profissao, $datanasc, $foto, $ativo) {
        $emailExistente = $this->existeEmail($email);
        if(count($emailExistente) == 0) {
            try{
                $this->nome = $nome;
                $this->endereco = $endereco;
                $this->email = $email;
                $this->telefone = $telefone;
                $this->redesocial = $redesocial;
                $this->profissao = $profissao;
                $this->datanasc = $datanasc;
                $this->foto = $foto;
                $this->ativo = $ativo;
                $sql = $this->con->conectar()->prepare("INSERT INTO contatos (nome, endereco, email, telefone, redesocial, profissao, datanasc, foto, ativo) VALUES (:nome, :endereco, :email, :telefone, :redesocial, :profissao, :datanasc, :foto, :ativo)");
                $sql->bindParam(":nome", $this->nome, PDO::PARAM_STR);
                $sql->bindParam(":endereco", $this->endereco, PDO::PARAM_STR);
                $sql->bindParam(":email", $this->email, PDO::PARAM_STR);
                $sql->bindParam(":telefone", $this->telefone, PDO::PARAM_STR);
                $sql->bindParam(":redesocial", $this->redesocial, PDO::PARAM_STR);
                $sql->bindParam(":profissao", $this->profissao, PDO::PARAM_STR);
                $sql->bindParam(":datanasc", $this->datanasc, PDO::PARAM_STR);
                $sql->bindParam(":foto", $this->foto, PDO::PARAM_STR);
                $sql->bindParam(":ativo", $this->ativo, PDO::PARAM_STR);
                $sql->execute();
                return TRUE;

            }catch(PDOException $ex) {
                return 'ERRO: ' . $ex->getMessage();
            }
        }else{
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

    public function buscar($id) {
        try{
            $sql = $this->con->conectar()->prepare(" SELECT * FROM contatos WHERE id_contatos = :id ");
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

    public function editar($nome, $endereco, $email, $telefone, $redesocial, $profissao, $datanasc, $foto, $ativo, $id) {
            $emailExistente = $this->existeEmail($email);
            if (count($emailExistente) > 0 && $emailExistente['id'] != $id) {
                return FALSE;
            } else {
                try{
                    $sql = $this->contatos->conectar()->prepare("UPDATE contatos SET nome = :nome, endereco = :endereco, email = :email, telefone = :telefone, redesocial = :redesocial, profissao = : profissao, datanasc = :datanasc, foto = :foto, ativo = :ativo WHERE id = :id");
                    $sql->bindValue(":nome", $nome);
                    $sql->bindValue(":endereco", $endereco);
                    $sql->bindValue(":email", $email);
                    $sql->bindValue(":telefonee", $telefone);
                    $sql->bindValue(":redesocial", $redesocial);
                    $sql->bindValue(":profissao", $profissao);
                    $sql->bindValue(":datanasc", $datanasc);
                    $sql->bindValue(":foto", $foto);
                    $sql->bindValue(":ativo", $ativo);
                    $sql->bindValue(":id", $id);
                    $sql->execute();
                    return TRUE;
                } catch(PDOException $ex) {
                    echo "Erro: ".$ex->getMessage();
                }
            }
        }
    }