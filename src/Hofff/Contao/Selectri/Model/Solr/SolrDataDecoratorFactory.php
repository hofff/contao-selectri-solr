<?php

namespace Hofff\Contao\Selectri\Model\Solr;

use Hofff\Contao\Selectri\Model\Data;
use Hofff\Contao\Selectri\Model\DataFactory;
use Hofff\Contao\Selectri\Widget;
use Hofff\Contao\Solr\Index\QueryExecutor;
use Hofff\Contao\Solr\Index\RequestHandler;
use Hofff\Contao\Solr\Index\RequestHandlerFactory;

class SolrDataDecoratorFactory implements DataFactory {

	/**
	 * @var DataFactory
	 */
	private $factory;

	/**
	 * @var SolrDataConfig
	 */
	private $config;

	/**
	 * @param Data $delegate
	 */
	public function __construct() {
		$this->config = new SolrDataConfig;
	}

	/**
	 * @see \Hofff\Contao\Selectri\Model\DataFactory::setParameters()
	 */
	public function setParameters($params) {
	}

	/**
	 * @see \Hofff\Contao\Selectri\Model\DataFactory::createData()
	 */
	public function createData(Widget $widget = null) {
		$decoratedData = $this->factory->createData($widget);
		$config = clone $this->config;
		$this->prepareConfig($config);
		return new SolrDataDecorator($decoratedData, $config);
	}

	/**
	 * @return SolrDataConfig
	 */
	public function getConfig() {
		return $this->config;
	}

	/**
	 * @param DataFactory $factory
	 * @return void
	 */
	public function setDecoratedDataFactory(DataFactory $factory) {
		$this->factory = $factory;
	}

	/**
	 * @param integer|RequestHandler $handler
	 * @return void
	 */
	public function setRequestHandler($handler) {
		if(!$handler instanceof RequestHandler) {
			$handlerFactory = new RequestHandlerFactory;
			$handler = $handlerFactory->createByID($handler);
		}
		$this->config->setRequestHandler($handler);
	}

	/**
	 * @param string $field
	 * @return void
	 */
	public function setKeyField($field) {
		$callback = function($content) use($field) {
			$content = json_decode($content, true);

			$keys = array();
			if(isset($content['response']['docs'])) {
				foreach($content['response']['docs'] as $document) {
					$keys[] = $document[$field];
				}
			}

			return array_unique($keys);
		};
		$this->config->setExtractKeysCallback($callback);
	}

	/**
	 * @param SolrDataConfig $config
	 * @return void
	 */
	protected function prepareConfig(SolrDataConfig $config) {
		if(!$config->getQueryExecutor()) {
			$config->setQueryExecutor(new QueryExecutor);
		}
	}

}
