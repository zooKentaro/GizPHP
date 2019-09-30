<?php
require_once('connection.php');
session_start();

//エスケープ処理
function e($text)
{
    //引数で受け取った文字から"や'<,>を変換する
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}

//SESSIONに暗号化したtokenを入れる
function setToken()
{
    $_SESSION['token'] = sha1(uniqid(mt_rand(), true));
}

//SESSIONに格納されていたtokenのチェックを行いCSRF対策を行う
function checkToken($token)
{
    if (empty($_SESSION['token']) || ($_SESSION['token'] !== $token)) {
        $_SESSION['err'] = '不意性な操作です';
        redirectToPostedPage();
    }
}

function unsetSession()
{
    $_SESSION['err'] = '';
}

function getTodoList()
{
	return getAllRecords();
}

function getSelectedTodo($id)
{
	return getTodoTextById($id);
}

function savePostedData($post)
{
    validate($post);
	$path = getRefererPath();
	switch ($path) {
		case '/new.php':
            checkToken($post['token']);
			createTodoData($post['todo']);
			break;
		case '/edit.php':
            checkToken($post['token']);
			updateTodoData($post);
			break;
        case '/index.php':
            deleteTodoData($post['id']);
            break;
		default:
			break;
	}
}

function validate($post)
{
    if (isset($post['todo']) && $post['todo'] === '') {
        $_SESSION['err'] = "入力がありません";
        redirectToPostedPage();
    }
}

function redirectToPostedPage()
{
    header('Location:'.$_SERVER['HTTP_REFERER']);
    exit();
}

function getRefererPath()
{
	$urlArray = parse_url($_SERVER['HTTP_REFERER']);
	return $urlArray['path'];
}
