<?php

class ApplicationTest extends TestCase
{
    /** @test */
    public function test_home_page()
    {
        $this->visit('/')
            ->assertResponseStatus(200);
    }

    /** @test */
    public function test_category_page()
    {
        $this->visit('/gida-c-201')
            ->seeText('Gıda Çeşitleri');
    }

    /** @test */
    public function test_search_page()
    {
        $this->visit('/search?q=domates')
            ->dontSeeText('araması için 0 sonuç bulundu.');
    }

    /** @test */
    public function test_category_search_page()
    {
        // Check normal search
        $this->visit('/c/gida/search?q=cif')
            ->dontSeeText('araması için 0 sonuç bulundu.');

        // Check null search
        $this->visit('/c/gida/search?q=')
            ->assertResponseOk();
    }

    /** @test */
    public function test_new_register_page_link()
    {
        $this->visit('/')
            ->click('Yeni Üyelik')
            ->seePageIs('/uye-ol')
            ->seeText('ÜYE OL');
    }

    /** @test */
    public function test_product_add_to_cart()
    {
        $this->post('/getAddToCart', ['product_id' => '541913', 'quantity' => 5])
            ->seeJson(['status' => 200, 'message' => 'success', 'count' => 5, 'total' => '699,50'])
            ->visit('/sepet')
            ->seeText('Ramazan Paketi 2 - 21 Çeşit Ürün')
            ->visit('/remove/541913')
            ->visit('/sepet')
            ->dontSeeText('Ramazan Paketi 2 - 21 Çeşit Ürün');
    }
}
