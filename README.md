<div id="top"></div>

## 使用技術一覧

<!-- シールド一覧 -->
<!-- 該当するプロジェクトの中から任意のものを選ぶ-->
<p style="display: inline">
  <!-- フロントエンドのフレームワーク一覧 -->
  <img src="https://img.shields.io/badge/-Alpine.js-8BC0D0.svg?logo=alpine.js&style=for-the-badge&logoColor=white">
  <img src="https://img.shields.io/badge/-Tailwindcss-06B6D4.svg?logo=tailwindcss&style=for-the-badge&logoColor=white">
  <!-- バックエンドのフレームワーク一覧 -->
  <img src="https://img.shields.io/badge/-Laravel-FF2D20.svg?logo=laravel&style=for-the-badge&logoColor=white">
  <!-- バックエンドの言語一覧 -->
  <img src="https://img.shields.io/badge/-PHP-777BB4.svg?logo=php&style=for-the-badge&logoColor=white">
  <!-- ミドルウェア一覧 -->
  <img src="https://img.shields.io/badge/-Nginx-269539.svg?logo=nginx&style=for-the-badge&logoColor=white">
  <img src="https://img.shields.io/badge/-MySQL-4479A1.svg?logo=mysql&style=for-the-badge&logoColor=white">
  <img src="https://img.shields.io/badge/-Node.js-4479A1.svg?logo=nodedotjs&style=for-the-badge&logoColor=white">
  <!-- インフラ一覧 -->
  <img src="https://img.shields.io/badge/-Docker-1488C6.svg?logo=docker&style=for-the-badge&logoColor=white">
</p>

## 目次

1. [プロジェクトについて](#プロジェクトについて)
2. [環境](#環境)
3. [ディレクトリ構成](#ディレクトリ構成)
4. [開発環境構築](#開発環境構築)

<!-- プロジェクト名を記載 -->

## プロジェクト名

PeerPerk

<!-- プロジェクトについて -->

## プロジェクトについて

ピアボーナス制度を利用した社内の共有文化を促進するサービスです。

このサービスには、あらゆる共有をテーマにしたアプリが複数組み込まれています。
- Peer Item (物の共有)
- Peer Event (イベントの共有)
- Peer Request (需要の共有)

将来的には以下のアプリを組み込むことを想定しています。
- Peer Thanks (感謝の共有)
- Peer Values (価値観の共有)
- Peer Knowledge (知識の共有)...etc

詳しくは以下のURLからこのプロジェクトの概要をご覧ください。

[Google ドキュメント](https://docs.google.com/document/d/1ssus2g8oIvpC8n7IPfhMEr5TLwR_ngk_s__T-9KWcSA/edit?usp=sharing)

## 環境

<!-- 言語、フレームワーク、ミドルウェア、インフラの一覧とバージョンを記載 -->

| 言語・フレームワーク  | バージョン |
| --------------------- | ---------- |
| alpine                | 3.16       |
| Laravel               | 9.52.16    |
| PHP                   | 8.1        |
| Nginx                 | 1.18       |
| MySQL                 | 8.0        |
| node                  | 18.12.0    |

その他のパッケージのバージョンは package.json を参照してください

<p align="right">(<a href="#top">トップへ</a>)</p>

## ディレクトリ構成

<!-- Treeコマンドを使ってディレクトリ構成を記載 -->
srcフォルダ内はLaravelの標準的なディレクトリ構造と同一のため、多少省いております。
```
.
├── README.md
├── .github
│   ├── issue_template.md
│   └── pull_request_template.md
├── .github
│   └── settings.json
├── docker
│   ├── .gitignore
│   ├── docker-compose.yml
│   ├── package-lock.json
│   ├── app
│   │   ├── usr
│   │   │   └── local
│   │   │       └── etc
│   │   │           └── php
│   │   │               └── php.ini
│   │   └── Dockerfile
│   ├── db
│   │   └── etc
│   │   │   └── mysql
│   │   │       └── conf.d
│   │   │           └── my.cnf
│   │   └── Dockerfile
│   └── web
│       ├── etc
│       │   └── nginx
│       │       └── conf.d
│       │           └── default.conf
│       └── Dockerfile
└── src
    ├── app
    │   └── ...
    ├── bootstrap
    │   └── ...
    ├── config
    │   └── ...
    ├── database
    │   └── ...
    ├── lang
    │   └── ...
    ├── public
    │   └── ...
    ├── resources
    │   └── ...
    ├── routes
    │   └── ...
    ├── storage
    │   └── ...
    ├── tests
    │   └── ...
    ├── .editconfig
    ├── .gitattributes
    ├── .gitignore
    ├── artisan
    ├── composer.json
    ├── composer.lock
    ├── package-lock.json
    ├── package.json
    ├── phpunit.yml
    ├── postcss.config.js
    ├── README.md
    ├── vite.config.js
    └── tailwind.config.js
```

<p align="right">(<a href="#top">トップへ</a>)</p>

## 開発環境構築

<!-- コンテナの作成方法、パッケージのインストール方法など、開発環境構築に必要な情報を記載 -->

### branch運用
| branch名  | 役割 |
| --------------------- | ---------- |
| main                  | 実際のプロダクトに使われているコード           |
| develop               | 変更を行うときに利用するブランチ              |
| deploy                | main環境からslack連携を削除した環境[^1]    |

以下の手順は全て`deploy`ブランチで行なってください。

他のブランチで行うとslackワークスペースに所属していないためエラーが出ます。

[^1]: デモ環境を利用していただく際に、slackのワークスペースに毎回追加する手間を省くためにこの環境を作っております。

### envファイルの作成

以下のコマンドで.env.sampleをコピー
```
cd src/
copy .env.sample .env
```

### コンテナの作成と起動

以下のコマンドで開発環境を構築[^2] 

[^1]: dockerをインストールする必要があります

```
docker compose build --no-cache
docker compose up -d
```

コンテナ立ち上げ後、以下のコマンドでマイグレーションとシーディングを実行
```
docker compose exec ph3-posseapp-app bash
composer install
php artisan migrate:refresh --seed
php artisan optimze:clear
```

### 動作確認

http://localhost にアクセスできるか確認

アクセスできたら成功

### コンテナの停止

以下のコマンドでコンテナを停止することができます

```
docker compose down
```

<p align="right">(<a href="#top">トップへ</a>)</p>
