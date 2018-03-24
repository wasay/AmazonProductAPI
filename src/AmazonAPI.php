<?php
/**
 *  Amazon Product API Library
 *
 *  @author Marc Littlemore
 *  @link 	http://www.marclittlemore.com
 *
 */

namespace MarcL;

use MarcL\CurlHttpRequest;
use MarcL\AmazonUrlBuilder;
use MarcL\Transformers\DataTransformerFactory;

class AmazonAPI
{
	private $urlBuilder = NULL;
	private $dataTransformer = NULL;

	// Valid names that can be used for search
	private $mValidSearchNames = NULL;
	private $mValidResponseGroups = NULL;
	private $mValidSortValues = NULL;

	private $mErrors = array();

	public function __construct($urlBuilder, $outputType,
		$params = array(
			'searchNames' => NULL,
			'responseGroups' => NULL,
			'sortValues' => NULL,
		)
	) {
		$this->urlBuilder = $urlBuilder;
		$this->dataTransformer = DataTransformerFactory::create($outputType);

		if ( isset($params['searchNames']) && ! empty($params['searchNames']) )
		{
			$this->mValidSearchNames = $params['searchNames'];
		}
		if ( isset($params['responseGroups']) && ! empty($params['responseGroups']) )
		{
			$this->mValidResponseGroups = $params['responseGroups'];
		}
		if ( isset($params['sortValues']) && ! empty($params['sortValues']) )
		{
			$this->mValidSortValues = $params['sortValues'];
		}
	}

	public function GetValidSearchNames() {
		return $this->mValidSearchNames;
	}

	public function GetValidResponseGroups() {
		return $this->mValidResponseGroups;
	}

	public function GetValidSortValues() {
		return $this->mValidSortValues;
	}

	/**
	 * Search for items
	 *
	 * @param	keywords			Keywords which we're requesting
	 * @param	searchIndex			Name of search index (category) requested. NULL if searching all.
	 * @param	sortBy				Category to sort by, only used if searchIndex is not 'All'
	 * @param	condition			Condition of item. Valid conditions : Used, Collectible, Refurbished, All
	 * @param	params				Additional params
	 *
	 * @return	mixed				SimpleXML object, array of data or false if failure.
	 */
	public function ItemSearch($keywords, $searchIndex = NULL, $sortBy = NULL, $condition = 'New',
		$item_search_params = array(
			'ResponseGroup' => 'ItemAttributes,Offers,Images',
			'Availability' => NULL,
			'IncludeReviewsSummary' => NULL,
			'ItemPage' => NULL,
			'MinimumPrice' => NULL,
			'MaximumPrice' => NULL,
			'TruncateReviewsAt' => NULL,
		)
	) {
		$params = array(
			'Operation' => 'ItemSearch',
			//'ResponseGroup' => 'ItemAttributes,Offers,Images',
			'Keywords' => $keywords,
			'Condition' => $condition,
			'SearchIndex' => empty($searchIndex) ? 'All' : $searchIndex,
			'Sort' => $sortBy && ($searchIndex != 'All') ? $sortBy : NULL
		);

		if (is_array($item_search_params))
		{
			foreach ($item_search_params as $item_key => $item)
			{
				if ( $item != NULL && !empty($item))
				{
					$params[$item_key] = $item;
				}
			}
		}

		return $this->MakeAndParseRequest($params);
	}

	/**
	 * Lookup items from ASINs
	 *
	 * @param	asinList			Either a single ASIN or an array of ASINs
	 * @param	onlyFromAmazon		True if only requesting items from Amazon and not 3rd party vendors
	 * @param	params			Additional params
	 *
	 * @return	mixed				SimpleXML object, array of data or false if failure.
	 */
	public function ItemLookup($asinList, $onlyFromAmazon = false,
		$item_search_params = array(
			'ResponseGroup' => 'ItemAttributes,Offers,Reviews,Images,EditorialReview',
			'ReviewSort' => '-OverallRating',
		)
	) {
		if (is_array($asinList)) {
			$asinList = implode(',', $asinList);
		}

		$params = array(
			'Operation' => 'ItemLookup',
			//'ResponseGroup' => $responseGroup,
			//'ReviewSort' => $reviewSort,
			'ItemId' => $asinList,
			'MerchantId' => ($onlyFromAmazon == true) ? 'Amazon' : 'All'
		);

		if (is_array($item_search_params))
		{
			foreach ($item_search_params as $item_key => $item)
			{
				if ( $item != NULL && !empty($item))
				{
					$params[$item_key] = $item;
				}
			}
		}

		return $this->MakeAndParseRequest($params);
	}

	public function GetErrors() {
		return $this->mErrors;
	}

	private function AddError($error) {
		array_push($this->mErrors, $error);
	}

	private function MakeAndParseRequest($params) {
		$signedUrl = $this->urlBuilder->generate($params);

		try {
			$request = new CurlHttpRequest();
			$response = $request->execute($signedUrl);

			$parsedXml = simplexml_load_string($response);

			if ($parsedXml === false) {
				return false;
			}

			return $this->dataTransformer->execute($parsedXml);
		} catch(\Exception $error) {
			$this->AddError("Error downloading data : $signedUrl : " . $error->getMessage());
			return false;
		}
	}
}
?>
