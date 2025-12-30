<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\StudyProgram;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductAccessTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;
    private User $mahasiswa;
    private User $pelanggan;

    protected function setUp(): void
    {
        parent::setUp();

        $prodi = StudyProgram::factory()->create();

        // Create users with different roles
        $this->admin = User::factory()->create(['role' => 'admin', 'prodi_id' => $prodi->id]);
        $this->mahasiswa = User::factory()->create(['role' => 'mahasiswa', 'prodi_id' => $prodi->id]);
        $this->pelanggan = User::factory()->create(['role' => 'pelanggan', 'prodi_id' => $prodi->id]);
    }

    /** @test */
    public function guests_are_redirected_from_product_creation_page()
    {
        $response = $this->get(route('products.create'));
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function customers_are_forbidden_from_accessing_product_creation_page()
    {
        $response = $this->actingAs($this->pelanggan)->get(route('products.create'));
        $response->assertForbidden();
    }

    /** @test */
    public function mahasiswa_can_access_product_creation_page()
    {
        $response = $this->actingAs($this->mahasiswa)->get(route('products.create'));
        $response->assertOk();
    }

    /** @test */
    public function admin_can_access_product_creation_page()
    {
        $response = $this->actingAs($this->admin)->get(route('products.create'));
        $response->assertOk();
    }

    /** @test */
    public function anyone_can_view_the_product_listing_page()
    {
        // This test assumes you have a public product listing page.
        // The controller logic now filters for 'verified' products.
        $response = $this->get(route('products.index'));
        $response->assertOk();
    }
}
