
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="index.php"></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">

        <li class="nav-item active">
            <a class="nav-link" href="index.php">Accueil <span class="sr-only"></span></a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="articles.php">Article</a>
        </li>

        <li class="nav-item">
            <?php
            if(isConnected()){
                echo'<a class="nav-link " href="logout.php">Déconnexion</a>';
            }else{
                echo'<a class="nav-link " href="connexion.php">Connexion</a>';
            }
            ?>
        </li>

        <li class="nav-item">
            <?php
            if(isConnected()){
                echo'<a class="nav-link " href="profil.php">Profil</a>';
            }else{
                echo'<a class="nav-link " href="inscription.php">Inscription</a>';
            }
            ?>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="admin_add_article.php">Admin-Add</a>
        </li>

        </ul>
        <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Search">
        <button class="btn bg-danger my-2 my-sm-0" type="submit">Recherche</button>
        </form>
    </div>
    </nav>
