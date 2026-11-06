<?php

class Usuario {
    private $nome;

    private static $usuarios = array();

    public function __construct($nome) {
        $this->nome = $nome;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setNome($nome) {
        $this->nome = $nome;
    }

    private static function iniciarSessao() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Método SET para alimentar o array de usuários.
     */
    public static function setUsuarios(array $novosUsuarios) {
        self::iniciarSessao();

        self::$usuarios = array();

        foreach ($novosUsuarios as $usuario) {
            if (is_array($usuario) && isset($usuario['nome'])) {
                $nome = trim($usuario['nome']);
            } else {
                $nome = trim((string) $usuario);
            }

            if ($nome !== '') {
                self::$usuarios[] = array('nome' => $nome);
            }
        }

        self::salvar();
    }

    /**
     * Método SET alternativo recebendo apenas um array de nomes.
     * Exemplo: Usuario::setNomes(array('Ana', 'Carlos'));
     */
    public static function setNomes(array $nomes) {
        self::setUsuarios($nomes);
    }

    /**
     * Carrega os usuários salvos na sessão.
     */
    public static function carregar() {
        self::iniciarSessao();

        self::$usuarios = array();

        if (isset($_SESSION['usuarios']) && is_array($_SESSION['usuarios'])) {
            foreach ($_SESSION['usuarios'] as $usuario) {
                if (is_array($usuario) && isset($usuario['nome'])) {
                    $nome = trim($usuario['nome']);

                    if ($nome !== '') {
                        self::$usuarios[] = array('nome' => $nome);
                    }
                }
            }
        }
    }

    /**
     * Salva os usuários na sessão.
     */
    private static function salvar() {
        self::iniciarSessao();

        $_SESSION['usuarios'] = self::$usuarios;
    }

    /**
     * Inicializa a lista com os nomes padrão apenas se ainda não existir sessão.
     */
    private static function inicializarSeNecessario() {
        self::iniciarSessao();

        if (!isset($_SESSION['usuarios'])) {
            self::$usuarios = array(
                array('nome' => 'João'),
                array('nome' => 'Maria'),
                array('nome' => 'Bernardo'),
                array('nome' => 'Cláudio'),
                array('nome' => 'José'),
                array('nome' => 'Pedro')
            );

            self::salvar();
        } else {
            self::carregar();
        }
    }

    /**
     * Adiciona um novo usuário mantendo os anteriores.
     */
    public static function adicionarUsuario($nome) {
        self::inicializarSeNecessario();

        $nome = trim((string) $nome);

        if ($nome === '') {
            return false;
        }

        self::$usuarios[] = array('nome' => $nome);

        self::salvar();

        return true;
    }

    /**
     * Retorna todos os usuários como objetos Usuario.
     */
    public static function listarTodos() {
        self::inicializarSeNecessario();

        $listaUsuarios = array();

        foreach (self::$usuarios as $usuario) {
            $listaUsuarios[] = new Usuario($usuario['nome']);
        }

        return $listaUsuarios;
    }
}

?>