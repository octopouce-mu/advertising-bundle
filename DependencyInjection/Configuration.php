<?php
/**
 * Created by Kévin Hilairet <kevin@octopouce.mu>
 * Date: 30/05/2018
 */

namespace Octopouce\AdvertisingBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface {

	public function getConfigTreeBuilder()
	{
		$builder = new TreeBuilder();
		$builder
			->root('octopouce')
			->beforeNormalization()
				->always(function (array $config) {
					if (empty($config)) {
						return [
							'advertising' => [
								'enabled' => true
							]
						];
					}

					return $config;
				})
			->end()
			->children()
				->arrayNode('advertising')
					->children()
						->booleanNode('enabled')->defaultFalse()->treatNullLike(false)->end()
					->end()
				->end()
			->end()
		;

		return $builder;
	}
}