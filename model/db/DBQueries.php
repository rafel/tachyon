<?php
	# Name: MySQL.class.php
	# File Description: MySQL Class is class used to allow easy communcation with the database
	# Author: Rafel Ridha
	# Web: http://www.rafel.tk/
	# Update: 2011-02-01
	# Version: 1.0
	# Copyright 2011 rafel.tk
	

	$selectAllPosts = "SELECT
	profile.*,user.id,user.username, post.*, (SELECT count(comment.id) FROM comment WHERE comment.postid=post.id) AS commentnr
	FROM
	post JOIN user ON post.userid = user.id
LEFT JOIN profile ON user.id = profile.userid
	WHERE post.id NOT IN(SELECT postid FROM posttemp) ORDER BY created DESC";

	$selectAllUserPosts = "SELECT profile.*, user.id,user.username, post.* , (SELECT count(comment.id) FROM comment WHERE comment.postid=post.id) AS commentnr FROM post JOIN user ON post.userid = user.id LEFT JOIN profile ON user.id = profile.userid WHERE post.id NOT IN(SELECT postid FROM posttemp) AND post.userid='%d' ORDER BY created DESC";



	$selectComments = "SELECT user.id,user.username, comment.* FROM comment JOIN user ON comment.userid = user.id WHERE comment.id NOT IN(SELECT postid FROM posttemp) AND comment.postid='%d' ORDER BY created DESC";



	##End MySQL##
?>