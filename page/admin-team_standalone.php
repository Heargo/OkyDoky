<div class="adminTeamContainer">
    <!-- createur -->
    <div class="creator" onclick="document.location.href='./user/<?=$currentCom->get_owner()->nickname()?>'">
        <h3>Créateur</h3>
        <?php
            $creator = $currentCom->get_owner();
            $creatorname = $currentCom->get_owner()->display_name();

        ?>
        <img src="<?=$creator->profile_pic()?>" alt="profil">
        <p><?=$creatorname?></p>
    </div>
    <!-- equipe -->
    <div class="team">
        <?php 
        //$team = array();
        $team = $currentCom->get_team(new Permission(P::ADMIN));
        ?>
        <h3>L'équipe</h3>
        <ul>
        <?php 
        foreach ($team as $key => $membre) {
            $init = $membre->display_name()[0];
            $urlUser=Routes::url_for('/img/svg/users.svg')
            ?>
            <li onclick="document.location.href='./user/Bouba'"><img src="<?=$membre->profile_pic()?>"><p><?=$init?>.</p></li>
            <?php 
        }
        ?>
        <li onclick="document.location.href='?page=users'"><img src="<?=Routes::url_for('/img/svg/add-circle.svg')?>"></li>
        </ul>

    </div>
    
</div>