<?php

namespace CyberDuck\LaravelGoogleTagManager

class GTM {

    /**
     * The Tag Manager container ID
     *
     * @var int
     */
	private $id;

    /**
     * The Tag Manager container ID
     *
     * @var int
     */
	private $data = array();

	private $events = array();

	private $purchases = array();

	private $refunds = array();

	/**
	 * 
	 *
	 * @param string $name  DataLayer var name
	 * @param string $value DataLayer var value
	 *
	 * @return void
	 */
	public function data($name, $value)
	{

	}

	/**
	 * 
	 *
	 * @param string $name  DataLayer var name
	 * @param string $value DataLayer var value
	 *
	 * @return void
	 */
	public function event($name)
	{

	}

	/**
	 * 
	 *
	 * @param array $params An array of purchase fields
	 *
	 * @return void
	 */
	public function purchase($params)
	{

	}

	/**
	 * 
	 *
	 * @param array $params An array of purchase individual item fields
	 *
	 * @return void
	 */
	public function purchaseItem($params)
	{

	}

	/**
	 * 
	 *
	 * @param int $id The id of a purchase item to refund
	 *
	 * @return void
	 */
	public function refund($id)
	{

	}

	/**
	 * 
	 *
	 * @return string
	 */
	public function code()
	{

	}

	/**
	 * 
	 *
	 * @param int $id The id of the Tag manager container
	 *
	 * @return void
	 */
	public function id($id)
	{

	}

	/**
	 * 
	 *
	 * @param int $id The id of the Tag manager container
	 *
	 * @return void
	 */
	public function dataLayer()
	{

	}
}