<?php

namespace Hofff\Contao\Selectri\Model\Solr;

use Hofff\Contao\Selectri\Model\Data;

class SolrSearchDataDecoratorFactory extends AbstractSolrDataDecoratorFactory {

	/**
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * @see \Hofff\Contao\Selectri\Model\Solr\AbstractSolrDataDecoratorFactory::createDecorator()
	 */
	protected function createDecorator(Data $decoratedData, SolrDataConfig $config) {
		return new SolrSearchDataDecorator($decoratedData, $config);
	}

}
