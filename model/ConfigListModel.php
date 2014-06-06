<?php
	class ConfigListModel{

	public $location = 
	array ( 
		"controller"  => array ( 
			"home" 			=> "HomeController",
			"user" 			=> "UserController",
			"post"			=> "PostController"
		),
		
		"root"  => array ( 
			"Index" 			=> "index.php",
		),
		
		"conf"  => array ( 
			"MySQL" 			=> "model/Conf.MySQL.php"
		),
		
		"script"  => array ( 
			"Template" 			=> "model/Script.TemplateEngine.php",
			"Message" 			=> "model/Script.MessageEngine.php",
			"Language" 			=> "model/Script.LanguageEngine.php",
			"SendPost" 			=> "model/Script.SendPost.php",
			"RemovePost"		=> "model/Script.RemovePost.php",
			"UploadImage" 		=> "model/Script.UploadImage.php",			
			"ChangePassword"	=> "model/Script.ChangePassword.php",			
			"SaveSettings"		=> "model/Script.SaveSettings.php",
			"Register"			=> "model/Script.Register.php",
			"Login"				=> "model/Script.Login.php",
			"LogOut"			=> "model/Script.LogOut.php"
			
		),
		
		"style"  => array ( 
			"Global" 			=> "view/style/global.css",
			"GlobalOnline" 		=> "view/style/globalOnline.css"
		),
		
		"file"  => array ( 
			"User_Image_upload"	=> "files/images/",
			"Style_Folder"		=> "view/style/"
		),
		
		"lang"  => array ( 
			"sv" 				=> "model/Lang.Sv.Global.php",
			"Sv.Msg" 			=> "model/Lang.Sv.Msg.php",
			"Sv.Page" 			=> "model/Lang.Sv.Page.php",
			"eng" 				=> "model/Lang.Eng.Global.php",
			"Eng.Msg" 			=> "model/Lang.Eng.Msg.php",
			"Eng.Page" 			=> "model/Lang.Eng.Page.php"
		),
		
		"page"  => array ( 
			"Body" 				=> "model/Page.Body.php",
			"Home" 				=> "model/Page.Home.php",
			"Register" 			=> "model/Page.Register.php",
			"Profile" 			=> "model/Page.Profile.php",
			"Guestbook" 		=> "model/Page.Guestbook.php",
			"GetGBPost"			=> "model/Page.GetGBPost.php",
			"Search" 			=> "model/Page.Search.php",
			"SearchResult"		=> "model/Page.SearchResult.php",
			"Settings" 			=> "model/Page.Settings.php",
			"Password" 			=> "model/Page.Password.php",
			"Image" 			=> "model/Page.Image.php",
			"Header" 			=> "model/Page.Header.php",
			"OfflineHeader"		=> "model/Page.Offlineheader.php",
			"Footer" 			=> "model/Page.Footer.php",
			"404" 				=> "model/Page.404.php"
		),
		
		"template"  => array ( 
			"Body" 				=> "view/template/body.html",
			"Home" 				=> "view/template/home.html",
			"Register" 			=> "view/template/register.html",
			"Profile" 			=> "view/template/profile.html",
			"Guestbook" 		=> "view/template/guestbook.html",
			"GetGBPost"			=> "view/template/getGBpost.html",
			"Search" 			=> "view/template/search.html",
			"SearchResult"		=> "view/template/searchResult.html",
			"Settings" 			=> "view/template/settings.html",
			"Password" 			=> "view/template/password.html",
			"Image" 			=> "view/template/image.html",
			"Header" 			=> "view/template/header.html",
			"OfflineHeader"		=> "view/template/offlineheader.html",
			"Footer" 			=> "view/template/footer.html"
		)
		
	);
				
	}
?>