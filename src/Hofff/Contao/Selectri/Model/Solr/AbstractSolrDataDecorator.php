<?php

namespace Hofff\Contao\Selectri\Model\Solr;

use Hofff\Contao\Selectri\Model\DataDelegate;
use Hofff\Contao\Selectri\Model\Data;
use Hofff\Contao\Solr\Index\Query;

abstract class AbstractSolrDataDecorator extends DataDelegate {

	/**
	 * @var SolrDataConfig
	 */
	private $config;

	/**
	 * @param Data $delegate
	 */
	protected function __construct(Data $delegate, SolrDataConfig $config) {
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
	 * @param Query $query
	 * @return array<string>
	 */
	protected function executeQuery(Query $query) {
		$handler = $this->config->getRequestHandler();
		$content = $this->config->getQueryExecutor()->execute($handler, $query);
		$keys = call_user_func($this->config->getExtractKeysCallback(), $content, $this);
		return $keys;
	}

	/**
	 * @param Query $query
	 * @param array|null $args
	 * @return void
	 */
	protected function applyQueryBuilderCallback(Query $query, array $args = null) {
		$callback = $this->config->getQueryBuilderCallback();
		$callback && call_user_func($callback, $query, $this, $args);
	}

}
