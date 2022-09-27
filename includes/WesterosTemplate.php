<?php
/**
 * BaseTemplate class for the Westeros skin
 *
 * @ingroup Skins
 */

class WesterosTemplate extends BaseTemplate {
	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		$this->html( 'headelement' );
        $pageNav = $this->data['content_navigation'];
        if( !$this->data['loggedin'] ) {
			$loggedIn = false;
		}
		else {
			$loggedIn = true;
        }
        ?>
    <div id="main">
    <div id="mw-js-message" style="display:none;"></div>
    <?php if ( $this->data['newtalk'] ) { ?><div class="usermessage"><?php $this->html( 'newtalk' ); ?></div><?php } ?>
      <header id="header">
        <div class="logo">
          <a href="https://whiki.online/wiki/">
          <img id="header-img" src="/resources/assets/Whiki-Logo.png" alt="whiki.online logo">
          </a>
        </div>

        <input type="checkbox" class="menu-btn" id="menu-btn">
        <label for="menu-btn" class="menu-icon"><span class="navicon"></span></label>

        <nav id="nav-bar">
        <div class="menu">
        <div role="navigation" id="p-personal" class="mw-portlet mw-portlet-personal" title=" title=&quot;User menu&quot;" aria-labelledby="p-personal-label">
        <ul>
            <?php foreach ( $this->getPersonalTools() as $key => $item ) { ?>
	        <?php echo $this->makeListItem($key, $item); ?>

            <?php } ?>
        </ul>
            </div>
        </div>
        </nav>

      </header>
    </div>

    <!-- mod header -->
    <div class="mod-header">
        <div id="p-logo" class="mw-portlet" role="banner">
	<a href="<?php echo $this->data['nav_urls']['mainpage']['href'] ?>">
    <img src="<?php echo $this->data['logopath'] ?>" width="150" />
    </a>
        </div>

        <!-- navigation lets see if it works -->
        <ul class="nav" id="secondarynav">
            <?php
                $service = new WesterosSkinNavigationService();
                $menuNodes = $service->parseMessage(
                    'westeros-navigation',
                    60 * 60 * 3,
                    [ 10, 10, 10, 10, 10, 10 ]
                );

                if ( is_array( $menuNodes ) && isset( $menuNodes[0] ) ) {
                    $counter = 0;
                    foreach ( $menuNodes[0]['children'] as $level0 ) {
                        $hasChildren = isset( $menuNodes[$level0]['children'] );
            ?>
            <li class="page_item<?php echo ( $hasChildren ? ' page_item_has_children' : '' ) ?>">
                <a class="nav<?php echo $counter ?>_link" href="<?php echo htmlspecialchars( $menuNodes[$level0]['href'], ENT_QUOTES ) ?>"><?php echo htmlspecialchars( $menuNodes[$level0]['text'], ENT_QUOTES ) ?></a>
                <?php if ( $hasChildren ) { ?>
                <ul class="children">
<?php
                    foreach ( $menuNodes[$level0]['children'] as $level1 ) {
?>
                    <li class="page_item">
                        <a href="<?php echo htmlspecialchars( $menuNodes[$level1]['href'], ENT_QUOTES ) ?>"><?php echo htmlspecialchars( $menuNodes[$level1]['text'], ENT_QUOTES ) ?></a>
<?php
                        if ( isset( $menuNodes[$level1]['children'] ) ) {
                            echo '<ul class="children">';
                            foreach ( $menuNodes[$level1]['children'] as $level2 ) {
?>
                            <li class="page_item">
                                <a href="<?php echo htmlspecialchars( $menuNodes[$level2]['href'], ENT_QUOTES ) ?>"><?php echo htmlspecialchars( $menuNodes[$level2]['text'], ENT_QUOTES ) ?></a>
                            </li>
<?php
                            }
                            echo '</ul>';
                            $counter++;
                        }
?>
                    </li>
<?php
                    }
                    echo '</ul>';
                    $counter++;
                } 
                echo '</li>';
                    } 
                }
?>
        </ul>

    <!-- search -->
    <form role="search" class="mw-portlet" id="p-search" action="<?php $this->text( 'wgScript' ); ?>">
        <input type='hidden' name="title" value="<?php $this->text( 'searchtitle' ) ?>" />
        <?php echo $this->makeSearchInput( array( 'id' => 'searchInput' ) ); ?>
        <?php echo $this->makeSearchButton( 'go', array( 'id' => 'searchGoButton', 'class' => 'searchButton' ) ); ?>
    </form>
    <!-- end mod header -->
    </div>
    <!-- content -->
    <div id="content" class="mw-body" role="main" style="height: auto !important; min-height: 0px !important;">
     <?php if ( $this->data['sitenotice'] ) { ?><div id="siteNotice"><?php $this->html( 'sitenotice' ); ?></div><?php } ?>
    <div class="article-header">
         <!-- Indicators -->
        <?php echo $this->getIndicators(); ?>
        <!-- Article title -->
        <ul id="mw-head-left">
            <?php		
            foreach ( $pageNav['namespaces'] as $key => $tab ) {
                echo $this->makeListItem( $key, $tab );
            }
            ?>
        </ul>

        <ul id="mw-head-right">
            <!-- "View", "Edit", "History" buttons -->
            <?php
            foreach ( $pageNav['views'] as $key => $tab ) {
                echo $this->makeListItem( $key, $tab );
            }
            
            if ( $this->data['isarticle'] && $loggedIn == true ) {
            ?>
                <div id="mw-head-more">
                    <div>
                        <a href="#">More</a>
                        <ul>
                            <?php
                                foreach ( $pageNav['actions'] as $key => $tab ) {
                                    echo $this->makeListItem( $key, $tab );
                                }

                                foreach ( $this->data['sidebar']['TOOLBOX'] as $key => $tab ) {
                                    echo $this->makeListItem( $key, $tab );
                                }
                                
                            ?>

                            
                        </ul>
                    </div>
                </div>
            <?php 
            }
            ?>
        </ul>
    </div>
		<h1 id="firstHeading" class="firstHeading mw-first-heading"><?php $this->html( 'title' ); ?></h1>
    <div id="bodyContent">
    <div id="site-sub">
        <?php if ( $this->data['isarticle'] ) { $this->msg( 'tagline' ); } ?>
        <?php if ( $this->data['subtitle'] ) { ?><div id="contentSub"><?php $this->html( 'subtitle' ); ?></div><?php } ?>
        <?php if ( $this->data['undelete'] ) { ?><div id="contentSub2"><?php $this->html( 'undelete' ); ?></div><?php } ?>
    </div>
    <?php $this->html( 'bodytext' ) ?>
    <?php $this->html( 'dataAfterContent' ); ?>
    <?php $this->html( 'catlinks' ); ?>
</div>
    </div>
<ul class="footerMeta">
    <?php
			if ( isset( $this->getFooterLinks()['info'] ) ) {
				$footerNav = $this->getFooterLinks()['info'] ?>
				<li id="footer-info-copyright"><?php $this->html( $footerNav[1] ) ?></li>
			<?php
			}
			?>
    <?php
			if ( isset( $this->getFooterLinks()['places'] ) ) {
				$footerPlaces = $this->getFooterLinks()['places'] ?>
				<li id="footer-places-mobileview"><?php $this->html( $footerPlaces[3] ) ?></li>
			<?php
			}
			?>
<ul>
    <!-- stylesheet/font -->
    <link href="https://blogfonts.com/css/aWQ9MTY2NTE0JnN1Yj01MTQmYz1tJnR0Zj1NaWtlU2Fuc0ZyZWUub3RmJm49bWlrZS1zYW5zLWZyZWU/Mike Sans Free.otf" rel="stylesheet" type="text/css"/>
		<?php $this->printTrail(); ?>
</body>
</html><?php
	}
}
