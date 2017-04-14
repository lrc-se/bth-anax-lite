        <h1>Om webbplatsen</h1>
        <p>
            Denna webbplats är en del i kursen <strong><a href="https://dbwebb.se/oophp">oophp</a></strong> i distansprogrammet <em>Webbprogrammering</em> 
            på <a href="http://www.bth.se/">Blekinge Tekniska Högskola</a>. Kursen behandlar främst objektorienterad PHP och databaskopplingar med MySQL.
        </p>
        <p>
            <a href="http://www.php.net/"><img src="<?= $app->href('img/elephpant.png', true) ?>" alt="PHP"></a>
            <span>&nbsp; &nbsp; &nbsp;</span>
            <a href="https://www.mysql.com/"><img src="<?= $app->href('img/mysql.png', true) ?>" alt="MySQL"></a>
        </p>
        <h4>Länkar</h4>
        <ul>
            <li><a href="https://github.com/lrc-se/bth-anax-lite">Webbplatsens källkod på GitHub</a></li>
            <li><a href="<?= $app->href('server') ?>">Visa serverinformation i JSON-format</a></li>
        </ul>
