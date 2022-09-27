<?php
/**
 * SkinTemplate class for the Example skin
 *
 * @ingroup Skins
 */
class SkinWesteros extends SkinTemplate {
	public $skinname = 'westeros',
		$stylename = 'Westeros',
		$template = 'WesterosTemplate';

	/**
	 * Add CSS via ResourceLoader
	 *
	 * @param OutputPage $out
	 */
	public function initPage( OutputPage $out ) {
		$out->addMeta( 'viewport',
			'width=device-width, initial-scale=1.0, ' .
			'user-scalable=yes, minimum-scale=0.25, maximum-scale=5.0'
		);

		$out->addModuleStyles( [
			'skins.westeros',
            'mediawiki.skinning.interface',
            'mediawiki.skinning.content',
            'mediawiki.skinning.elements',
		] );
		$out->addModules( [
			'skins.westeros.js'
		] );
	}

	/**
	 * @param OutputPage $out
	 */
	function setupSkinUserCss( OutputPage $out ) {
		parent::setupSkinUserCss( $out );
        $out->addModuleStyles( array(
			'mediawiki.skinning.interface', 'mediawiki.skinning.elements', 'mediawiki.skinning.content'
			/* 'skins.foobar' is the name you used in your skin.json file */
		) );
	}
}