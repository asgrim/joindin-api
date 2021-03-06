<?php

/**
 * @covers ApiView
 */
class ApiViewTest extends PHPUnit_Framework_TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testThatAReturnCodeSetViaHeaderIsReturnedWhenNoOtherReturnCodeIsSet()
    {
        $view = new ApiView();

        header('Foo: bar', false, 201);

        ob_start();
        $view->render('');
        $this->assertEquals('', ob_get_contents());
        ob_end_clean();

        $this->assertEquals(201, http_response_code());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testThatAReturnCodeSetViaSetHeaderIsReturnedEvenThoughAHeaderCodeIsSet()
    {
        $view = new ApiView();

        $view->setResponseCode(202);
        header('Foo: bar', false, 201);

        ob_start();
        $view->render('');
        $this->assertEquals('', ob_get_contents());
        ob_end_clean();

        $this->assertEquals(202, http_response_code());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testThatHeadersAreSet()
    {
        $view = new ApiView();

        $view->setResponseCode(202);
        header('Foo: bar', false, 201);

        ob_start();
        $view->render('');
        $this->assertEquals('', ob_get_contents());
        ob_end_clean();

        $expectedHeaders = [
            'Foo: bar',
        ];
        $this->assertEquals($expectedHeaders, xdebug_get_headers());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testThatHeadersAreSetViaSetHeaders()
    {
        $view = new ApiView();

        $view->setHeader('Bar', 'Foo');

        $view->render('');

        $expectedHeaders = [
            'Bar: Foo',
        ];
        $this->assertEquals($expectedHeaders, xdebug_get_headers());
    }
}