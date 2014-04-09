<?php  namespace Palmabit\Library\Tests;
use Palmabit\Library\Form\HtmlServiceProvider;

/**
 * Test HtmlServiceProviderTest
 *
 * @author jacopo beschi jacopo@jacopobeschi.com
 */
class HtmlServiceProviderTest extends TestCase {

    /**
     * @test
     **/
    public function it_istantiate_palmabit_form_builder()
    {
        $html_provider = new HtmlServiceProvider($this->app);
        $html_provider->register();

        $form_builder = $this->app['form'];

        $this->assertInstanceOf('Palmabit\Library\Form\FormBuilder', $form_builder);
    }
}
 