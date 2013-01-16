<?php

namespace V\HTTP;

class Status_Test extends \PHPUnit_Framework_TestCase
{
	public function testIsInformational()
	{
		$this->assertTrue(Status::isInformational(Status::HTTP_CONTINUE));
		$this->assertFalse(Status::isInformational(Status::HTTP_NOT_FOUND));
	}

	public function testIsSuccessful()
	{
		$this->assertTrue(Status::isSuccessful(Status::HTTP_OK));
		$this->assertFalse(Status::isSuccessful(Status::HTTP_NOT_FOUND));
	}

	public function testIsRedirect()
	{
		$this->assertTrue(Status::isRedirect(Status::HTTP_FOUND));
		$this->assertFalse(Status::isRedirect(Status::HTTP_NOT_FOUND));
	}

	public function testIsClientError()
	{
		$this->assertTrue(Status::isClientError(Status::HTTP_NOT_FOUND));
		$this->assertFalse(Status::isClientError(Status::HTTP_FOUND));
	}

	/**
	 * @depends testIsClientError
	 */
	public function testIsServerError()
	{
		$this->assertTrue(Status::isServerError(Status::HTTP_NOT_IMPLEMENTED));
		$this->assertFalse(Status::isServerError(Status::HTTP_CONTINUE));
	}

	/**
	 * @depends testIsServerError
	 */
	public function testIsError()
	{
		$this->assertTrue(Status::isError(Status::HTTP_NOT_FOUND));
		$this->assertTrue(Status::isError(Status::HTTP_NOT_IMPLEMENTED));
		$this->assertFalse(Status::isError(Status::HTTP_CONTINUE));
	}

	public function testGetMessage()
	{
		$this->assertEquals(
			'500 Internal Server Error',
			Status::getMessage(Status::HTTP_INTERNAL_SERVER_ERROR)
		);

		$this->assertEquals(null, Status::getMessage(900));
	}
}