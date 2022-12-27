### ⚠️ THIS IS A WIP REPO, DON'T USE IN A REAL PROJECT/PRODUCTION ⚠️

---

<h2 align="center">
    💾 Laravel Nova Dump Card
</h2>

<p align="center">
  <strong>A card for <a href="https://nova.laravel.com/">Laravel Nova</a> which allows you to dump the database.</strong>
<br>
This card is only working for MySQL and SQLite.
</p>

<p align="center">
  <a href="https://github.com/Nembie/NovaDumpCard/blob/main/LICENSE.md">
    <img src="https://img.shields.io/badge/license-MIT-blue.svg" alt="Released under the MIT license." />
  </a>
  <a href="https://github.com/Nembie/NovaDumpCard/pulls">
    <img src="https://img.shields.io/badge/PRs-welcome-brightgreen.svg" alt="PRs welcome!" />
  </a>
  <a href="https://packagist.org/packages/nembie/nova-dump-card">
    <img src="https://img.shields.io/packagist/v/nembie/nova-dump-card" alt="Packagist Version">
  </a>
</p>

<img src="https://github.com/Nembie/NovaDumpCard/blob/main/nova-dump-card.png" alt="Test case" />

## ⚙️ Installation

```composer require nembie/nova-dump-card```

## 🛠️ Usage

```
use Nembie\NovaDumpCard\NovaDumpCard;

...

public function cards()
{
    return [
        (new NovaDumpCard())
            ->sqlDumpPath('/opt/homebrew/bin/mysqldump') // By default is 'mysqldump'
            ->dumpPath(public_path()) // By default is storage_path()
            ->database('database_name')
    ];
}

```

## 🧰 Methods

- `sqlDumpPath()` - if you want to dump a MySQL database, the path to mysqldump (tip: `which mysqldump` to get the path)
- `dumpPath()` - where to save the generated dump, by default is storage
- `database()` - specifies the name of the database to dump, by default is `env(DB_DATABASE)`
