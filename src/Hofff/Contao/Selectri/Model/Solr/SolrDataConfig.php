<?php

namespace Hofff\Contao\Selectri\Model\Solr;

use Hofff\Contao\Solr\Index\RequestHandler;
use Hofff\Contao\Solr\Index\QueryExecutor;

class SolrDataConfig {

	/**
	 * @var QueryExecutor
	 */
	private $queryExecutor;

	/**
	 * @var RequestHandler
	 */
	private $requestHandler;

	/**
	 * @var callable
	 */
	private $queryBuilderCallback;

	/**
	 * @var callable
	 */
	private $extractKeysCallback;

	/**
	 */
	public function __construct() {
	}

	/**
	 * @return QueryExecutor
	 */
	public function getQueryExecutor() {
		return $this->queryExecutor;
	}

	/**
	 * @param QueryExecutor $executor
	 * @return void
	 */
	public function setQueryExecutor(QueryExecutor $executor) {
		$this->queryExecutor = $executor;
	}

	/**
	 * @return RequestHandler
	 */
	public function getRequestHandler() {
		return $this->requestHandler;
	}

	/**
	 * @param RequestHandler $handler
	 * @return void
	 */
	public function setRequestHandler(RequestHandler $handler) {
		$this->requestHandler = $handler;
	}

	/**
	 * @return callable|null
	 */
	public function getQueryBuilderCallback() {
		return $this->queryBuilderCallback;
	}

	/**
	 * @param callable|null $callback
	 * @return void
	 */
	public function setQueryBuilderCallback($callback) {
		$this->queryBuilderCallback = $callback;
	}

	/**
	 * @return callable|null
	 */
	public function getExtractKeysCallback() {
		return $this->extractKeysCallback;
	}

	/**
	 * @param callable|null $callback
	 * @return void
	 */
	public function setExtractKeysCallback($callback) {
		$this->extractKeysCallback = $callback;
	}

}
