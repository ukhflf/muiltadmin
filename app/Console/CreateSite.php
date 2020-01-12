<?php

namespace App\Console\Commands;

use App\User;
use Hyn\Tenancy\Environment;
use Illuminate\Console\Command;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Repositories\HostnameRepository;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Hyn\Tenancy\Models\Website;

class CreateSite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:site';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '创建站点';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        // 站点地址
        $sub_domain = $this->ask('请输入站点地址（如：www.coca-platform.com）');
        while ($sub_domain == '') {
            $sub_domain = $this->ask('请输入站点地址（如：www.coca-platform.com）');
        }
        // 登陆用户名
        $name = $this->ask('请输入站点超级管理员登陆名(必须为英文名)');
        while ($name == '') {
            $name = $this->ask('请输入站点超级管理员登陆名(必须为英文名)');
        }
        // 邮箱
        $email = $this->ask('请输入站点超级管理员邮箱');
        while ($email == '') {
            $email = $this->ask('请输入站点超级管理员邮箱');
        }
        // 密码
        $password = $this->ask('请输入站点超级管理员密码');
        while ($password == '') {
            $password = $this->ask('请输入站点超级管理员密码');
        }
        $update = [
            'name'     => $name,
            'email'    => $email,
            'password' => bcrypt($password),
        ];

        $website = new Website;
        app(WebsiteRepository::class)->create($website);

        $hostname = new Hostname();
        $hostname->fqdn = $sub_domain;
        $hostname = app(HostnameRepository::class)->create($hostname);
        app(HostnameRepository::class)->attach($hostname, $website);

        $tenancy = app(Environment::class);
        $tenancy->tenant($website);
        // 修改超级管理员账号信息
        User::query()->where('id', 1)->update($update);

        $this->info('地址：' . $sub_domain);
        $this->info('登陆名：' . $name);
        $this->info('密码：' . $password);
    }
}
