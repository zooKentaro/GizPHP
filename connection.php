<?php
require_once('config.php');

//PDOクラスのインスタンス化
function connectPdo()
{
	try {
		return new PDO(DSN, DB_USER, DB_PASSWORD);
	} catch (PDOException $e) {
		echo $e->getMessage();
		exit();
	}
}

//新規作成処理
function createTodoData($todoText)
{
	$dbh = connectPdo();
	$sql = 'INSERT INTO todos (todo) VALUES (:todoText)';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':todoText', $todoText, PDO::PARAM_STR);
	$stmt->execute();
}

//レコード取得処理
function getAllRecords()
{
	$dbh = connectPdo();
	$sql = 'SELECT * FROM todos WHERE deleted_at IS NULL';
	return $dbh->query($sql)->fetchAll();//query()はPDOStatmentオブジェクトを返す
}

//更新処理
function updateTodoData($post)
{
	$dbh = connectPdo();
	$sql = 'UPDATE todos SET todo = :todoText WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':todoText', $post['todo'], PDO::PARAM_STR);
	$stmt->bindValue(':id', $post['id'], PDO::PARAM_INT);
	$stmt->execute();
}

//ID取得処理
function getTodoTextById($id)
{
	$dbh = connectPdo();
	$sql = 'SELECT * FROM todos WHERE id = :id AND deleted_at IS NULL';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
	$data = $stmt->fetch();
	return $data['todo'];
}

//Todoデータ削除処理
function deleteTodoData($id)
{
	$dbh = connectPdo();
	$now = date('Y-m-d H:i:s');
	$sql = 'UPDATE todos SET deleted_at = :now WHERE id = :id';
	$stmt = $dbh->prepare($sql);
	$stmt->bindValue(':now', $now, PDO::PARAM_STR);
	$stmt->bindValue(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
}
