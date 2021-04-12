<div class="adminTeamContainer">
    <!-- createur -->
    <div class="creator" onclick="document.location.href='./user/<?=$currentCom->get_owner()->nickname()?>'">
        <h3>Créateur</h3>
        <?php
            $creator = $currentCom->get_owner();
            $creatorname = $currentCom->get_owner()->display_name();

        ?>
        <img src=<?=$creator->profile_pic()?> alt="profil">
        <p><?=$creatorname?></p>
    </div>
    <!-- equipe -->
    <div class="team hidden">
        <h3>L'équipe</h3>
        <ul>
            <li onclick="document.location.href='./user/Bouba'"><img src="./img/img1.jpg"><p>B.</p></li> <!-- B. est l'initiale du pseudo (Bouba) -->
            <li onclick="document.location.href='./user/JeSuisMalin'"><img src="./img/img1.jpg"><p>J.</p></li> <!-- J. est l'initiale du pseudo (JeSuisMalin) -->
            <li onclick="document.location.href='./user/LesFous'"><img src="./img/img1.jpg"><p>L.</p></li> <!-- etc -->
        </ul>

    </div>
    
</div>