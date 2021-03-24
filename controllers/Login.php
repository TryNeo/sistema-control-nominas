<?php
    require_once ("./libraries/core/controllers.php");

    class Login extends Controllers{
        public function __construct(){
            session_start();
            if (isset($_SESSION['login'])) {
                header('location:'.server_url.'dashboard');
            }
            parent::__construct();
        }

        public function login(){
            $data["page_id"] = 4;
            $data["tag_pag"] = "Login";
            $data["page_title"] = "Login | Iniciar sesión";
            $data["page_name"] = "login";
            $data["page"] = "login";
            $this->views->getView($this,"login",$data);

        }

        public function loginUser(){
            if ($_POST) {
                if (empty($_POST['username']) || empty($_POST['password'])) {
                    $data = array('status' => false,'msg' => 'Error de datos');
                }else{
                    $str_usuario = strtolower(strclean($_POST['username']));
                    $str_password = strclean($_POST['password']);
                    $request_user = $this->model->login_user($str_usuario);
                    if (empty($request_user)) {
                        $data = array('status' => false,'msg' => 'El usuario o la contraseña es incorrecto');

                    }else{
                        $data = $request_user;
                        if ($data['estado'] == 1) {
                            if(password_verify($str_password,$data['password'])){
                                $_SESSION['id_usuario'] = $data['id_usuario'];
                                $_SESSION['login'] = true;
                                $arrResponse = $this->model->sessionLogin($_SESSION['id_usuario']);
                                $_SESSION['user_data'] = $arrResponse;
                                $data = array('status' => true,'msg' => 'Ha iniciado sesión correctamente');
                            }else{
                                $data = array('status' => false,'msg' => 'La contraseña es incorrecto');
                            }
                        }else{
                            $data = array('status' => false,'msg' => 'Este usuario no existe en la base de datos');
                        }
                    }
                }
                echo json_encode($data,JSON_UNESCAPED_UNICODE);
            }
            die();
        }

    }


?>