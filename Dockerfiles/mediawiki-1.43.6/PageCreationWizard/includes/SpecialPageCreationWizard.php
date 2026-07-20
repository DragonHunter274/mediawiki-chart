<?php

namespace MediaWiki\Extension\PageCreationWizard;

use HTMLForm;
use SpecialPage;
use Status;
use Title;

class SpecialPageCreationWizard extends SpecialPage {

	public function __construct() {
		parent::__construct( 'PageCreationWizard', 'edit' );
	}

	public function execute( $par ) {
		$this->setHeaders();
		$this->checkPermissions();

		$this->getOutput()->addWikiMsg( 'pagecreationwizard-intro' );

		$formDescriptor = [
			'namespace' => [
				'type' => 'select',
				'label-message' => 'pagecreationwizard-namespace-label',
				'options-messages' => [
					'pagecreationwizard-ns-main'   => '',
					'pagecreationwizard-ns-intern'  => 'Intern',
				],
				'required' => true,
			],
			'title' => [
				'type' => 'text',
				'label-message' => 'pagecreationwizard-pagetitle-label',
				'placeholder-message' => 'pagecreationwizard-pagetitle-placeholder',
				'required' => true,
				'autofocus' => true,
				'size' => 60,
			],
		];

		HTMLForm::factory( 'ooui', $formDescriptor, $this->getContext() )
			->setMethod( 'post' )
			->setWrapperLegendMsg( 'pagecreationwizard-legend' )
			->setSubmitTextMsg( 'pagecreationwizard-submit' )
			->setSubmitProgressive()
			->setSubmitCallback( function ( array $data ) {
				return $this->onSubmit( $data );
			} )
			->show();
	}

	private function onSubmit( array $data ): bool {
		$namespace  = $data['namespace'];
		$pageTitle  = trim( $data['title'] );
		$fullTitle  = $namespace !== '' ? "$namespace:$pageTitle" : $pageTitle;
		$title      = Title::newFromText( $fullTitle );

		if ( !$title || !$title->canExist() ) {
			// Let HTMLForm show the error inline
			return false;
		}

		$this->getOutput()->redirect( $title->getEditURL() );
		return true;
	}

	protected function getGroupName() {
		return 'wiki';
	}
}
