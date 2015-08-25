<?php

namespace Hofff\Contao\Selectri\Model\Solr;

use Hofff\Contao\Selectri\Model\DataDelegate;
use Hofff\Contao\Selectri\Model\Data;
use Hofff\Contao\Solr\Index\Builder\SearchQueryBuilder;
use Hofff\Contao\Solr\Index\Query;

class SolrDataDecorator extends DataDelegate {

	/**
	 * @var SolrDataConfig
	 */
	private $config;

	/**
	 * @param Data $delegate
	 */
	public function __construct(Data $delegate = null, SolrDataConfig $config) {
		parent::__construct($delegate);
		$this->config = $config;
	}

	/**
	 * @return SolrDataConfig
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @see \Hofff\Contao\Selectri\Model\DataDelegate::validate()
	 */
	public function validate() {
		parent::validate();

		// TODO
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
		$handler = $this->config->getRequestHandler();
		$query = $this->buildSearchQuery($query, $limit, $offset);
		$content = $this->config->getQueryExecutor()->execute($handler, $query);
		$keys = call_user_func($this->config->getExtractKeysCallback(), $content, $this);
		return $this->getNodes($keys);
	}

	/**
	 * @param unknown $query
	 * @param unknown $limit
	 * @param unknown $offset
	 * @return Query
	 */
	protected function buildSearchQuery($query, $limit, $offset) {
		$searchQuery = new Query;
		$searchQuery->setParam('q', $query);
		$searchQuery->setParam('rows', $limit);
		$searchQuery->setParam('start', $offset);

		$callback = $this->config->getQueryBuilderCallback();
		$callback && call_user_func($callback, $searchQuery, $query, $limit, $offset, $this);

		return $searchQuery;
	}

}
