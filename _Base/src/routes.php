<?php
use core\Router;

$router = new Router();

$router->get('/', 'HomeController@index');

$router->get('/login', 'LoginController@entrar');
$router->post('/login', 'LoginController@entrarAction');
$router->get('/sair', 'LoginController@sair');

$router->get('/cadastro', 'CadastroController@cadastro');
$router->post('/cadastro', 'CadastroController@cadastroAction');

$router->get('/alterar_senha', 'CadastroController@alterarSenha');
$router->post('/alterar_senha_usuario_logado', 'CadastroController@alterarSenhaUsuarioLogadoAction');


$router->post('/alterar/usuario', 'CadastroController@alterarStatusAction');
$router->post('/resetar/senha', 'CadastroController@alterarSenhaUsuarioAction');
$router->post('/alterar_nivel', 'CadastroController@alterarNivelUsuarioAction');

$router->get('/nova_ocorrencia', 'OcorrenciaController@cadastrarOcorrencia');
$router->post('/nova_ocorrencia', 'OcorrenciaController@cadastrarOcorrenciaAction');
$router->post('/excluir/envolvido', 'OcorrenciaController@excluirEnvolvidoOcorrenciaAction');
$router->post('/excluir/ativo', 'OcorrenciaController@excluirAtivoOcorrenciaAction');
$router->post('/excluir/foto', 'OcorrenciaController@excluirFotoOcorrenciaAction');
$router->post('/excluir', 'OcorrenciaController@excluirOcorrenciaAction');
$router->get('/editar/{id}','OcorrenciaController@editarOcorrencia');
$router->post('/editar/{id}','OcorrenciaController@editarOcorrenciaAction');

$router->get('/nova_ocorrencia', 'OcorrenciaController@cadastrarOcorrencia');

$router->get('/pesquisa_datas','PesquisaController@pesquisarDatas');

$router->post('/pesquisa_id','PesquisaController@pesquisarPorIdAction');
$router->get('/pesquisa_id','PesquisaController@pesquisarPorId');

$router->post('/pesquisa_envolvido','PesquisaController@pesquisarPorEnvolvidoAction');
$router->get('/pesquisa_envolvido','PesquisaController@pesquisarPorEnvolvido');

$router->post('/pesquisa_tipo_natureza','PesquisaController@pesquisarPorTipoNaturezaAction');
$router->get('/pesquisa_tipo_natureza','PesquisaController@pesquisarPorTipoNatureza');



$router->get('/imprimir/{id}','HomeController@imprimirOcorrencia');







//$router->get('/sair');

