<?php

namespace Hofff\Contao\Selectri\Model\Solr;

use Hofff\Contao\Selectri\Model\DataDelegate;
use Hofff\Contao\Selectri\Model\Data;
use Hofff\Contao\Solr\Index\Builder\SearchQueryBuilder;
use Hofff\Contao\Solr\Index\Query;

class SolrSuggestDataDecorator extends AbstractSolrDataDecorator {

	/**
	 * @param Data $delegate
	 */
	public function __construct(Data $delegate, SolrDataConfig $config) {
		parent::__construct($delegate, $config);
	}

	/**
	 * @see \Hofff\Contao\Selectri\Model\Data::hasSuggestions()
	 */
	public function hasSuggestions() {
		return true;
	}

	/**
	 * @see \Hofff\Contao\Selectri\Model\Data::suggest()
	 */
	public function suggest($limit, $offset = 0) {
		$suggestQuery = $this->buildSuggestQuery($limit, $offset);
		$keys = $this->executeQuery($suggestQuery);
		return $this->getNodes($keys);
	}

	/**
	 * @param integer $limit
	 * @param integer $offset
	 * @return Query
	 */
	public function buildSuggestQuery($limit, $offset) {
		$suggestQuery = new Query;
		$suggestQuery->setParam('q', '*:*');
		$suggestQuery->setParam('rows', $limit);
		$suggestQuery->setParam('start', $offset);

		$this->applyQueryBuilderCallback($suggestQuery);

		return $suggestQuery;
	}

}
