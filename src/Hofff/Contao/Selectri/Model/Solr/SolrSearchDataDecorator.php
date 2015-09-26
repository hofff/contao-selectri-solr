<?php

namespace Hofff\Contao\Selectri\Model\Solr;

use Hofff\Contao\Selectri\Model\DataDelegate;
use Hofff\Contao\Selectri\Model\Data;
use Hofff\Contao\Solr\Index\Builder\SearchQueryBuilder;
use Hofff\Contao\Solr\Index\Query;

class SolrSearchDataDecorator extends AbstractSolrDataDecorator {

	/**
	 * @param Data $delegate
	 */
	public function __construct(Data $delegate, SolrDataConfig $config) {
		parent::__construct($delegate, $config);
	}

	/**
	 * @see \Hofff\Contao\Selectri\Model\Data::isSearchable()
	 */
	public function isSearchable() {
		return true;
	}

	/**
	 * @see \Hofff\Contao\Selectri\Model\Data::search()
	 */
	public function search($query, $limit, $offset = 0) {
		$searchQuery = $this->buildSearchQuery($query, $limit, $offset);
		$keys = $this->executeQuery($searchQuery);
		return $this->getNodes($keys);
	}

	/**
	 * @param string $query
	 * @param integer $limit
	 * @param integer $offset
	 * @return Query
	 */
	public function buildSearchQuery($query, $limit, $offset) {
		$searchQuery = new Query;
		$searchQuery->setParam('q', $query);
		$searchQuery->setParam('rows', $limit);
		$searchQuery->setParam('start', $offset);

		$this->applyQueryBuilderCallback($searchQuery);

		return $searchQuery;
	}

}
