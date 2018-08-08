<?php
/**
 * Created by PhpStorm.
 * User: lukaskammerling
 * Date: 11.07.18
 * Time: 18:31
 */

namespace Tests\tests;

use LKDev\HetznerCloud\Models\Datacenters\Datacenters;
use LKDev\HetznerCloud\Models\Images\Images;
use Tests\TestCase;

/**
 *
 */
class ImagesTest extends TestCase
{
    /**
     * @var Images
     */
    protected $images;

    /**
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->images = new Images($this->hetznerApi->getHttpClient());
    }

    /**
     *
     */
    public function testGet()
    {
        $image = $this->images->get(4711);
        $this->assertEquals($image->id, 4711);
        $this->assertEquals($image->name, 'ubuntu-16.04');
    }

    /**
     *
     */
    public function testAll()
    {
        $images = $this->images->all();

        $this->assertEquals(count($images), 1);
        $this->assertEquals($images[0]->id, 4711);
        $this->assertEquals($images[0]->name, 'ubuntu-16.04');

    }

    public function testUpdate()
    {
        $image = $this->images->get(4711);
        $updated_image = $image->update('My new Image description', 'snapshot');
        $this->assertEquals($image->id, $updated_image->id);
        $this->assertEquals('My new Image description', $updated_image->description);
    }

    public function testDelete()
    {
        $image = $this->images->get(4711);
        $this->assertTrue($image->delete());
    }

    public function testChangeProtection()
    {
        $image = $this->images->get(4711);
        $action = $image->changeProtection();
        $this->assertEquals('change_protection', $action->command);
        $this->assertEquals($image->id, $action->resources[0]->id);
        $this->assertEquals('image', $action->resources[0]->type);
    }
}