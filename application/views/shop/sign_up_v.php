
<!DOCTYPE html>
<html lang="ko">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>업체 회원가입</title>
    
     <!-- jQuery -->
    <script src="/guesthouse/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/guesthouse/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/guesthouse/js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/guesthouse/js/sb-admin-2.js"></script>

    <!-- Bootstrap Core CSS -->
    <link href="/guesthouse/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="/guesthouse/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/guesthouse/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/guesthouse/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                
                    <div class="panel-heading">
                        <h3 class="panel-title">업체 회원가입</h3>
                    </div>
                    
                    <div class="panel-body">
                        <form role="form" id=""method="post" action="sign_up_step">
                            <fieldset>
                                <div class="form-group">
									<label for="id">아이디(*)</label>
                                    <input class="form-control" placeholder="아이디를 입력하세요." name="id" type="id" autofocus>
                                </div>
                                
                                <div class="form-group">
									<label for="password">비밀번호(*)</label>
                                    <input class="form-control" placeholder="비밀번호를 입력하세요." name="password" type="password" value="">
                                </div>
                                
                                <div class="form-group">
									<label for="name">이름(*)</label>
                                    <input class="form-control" placeholder="이름을 입력하세요." name="name" type="name" value="">
                                </div>
                                
                                <div class="form-group">
									<label for="email">이메일</label>
                                    <input class="form-control" placeholder="이메일을 입력하세요. (선택)" name="email" type="email" value="">
                                </div>
                                
                                <div class="form-group text-center">
	                                <input type="submit" class="btn btn-lg btn-primary" onclick="sign_up_proc()" style="width: 49%;" value="회원가입"></input>
	                                <a class="btn btn-lg btn-warning" style="width: 49%;">취소</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</body>

</html>
