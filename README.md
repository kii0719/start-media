# メディアを始めよう！

## 環境構築

### 1. Docker をインストールします
[Docker for MacOS](https://docs.docker.com/docker-for-mac/install/) を参考に docker を install しましょう。  

### 2. Node.jsのインストールします

#### 2-1. nodebrewのインストールします

nodebrewを使うのでインストールします。  

```
$ curl -L git.io/nodebrew | perl - setup
```

`.bash_profile` or `.zshrc` に以下を追記  

```
export PATH=$HOME/.nodebrew/current/bin:$PATH
```

#### 2-2. 最新のNode.jsをインスールします

```
$ nodebrew install latest
$ nodebrew use latest
```

### 3. このリポジトリをcloneします

作業用のディレクトリなどがある場合は、そこに移動してください

```
$ git clone

```

### 4. wordpress と mysql の構築・実行

cloneしたディレクトリに移動します  

```
cd ./start-media
```

wordpressサーバーとDBサーバーを起動します  

```
$ docker-compose up -d
```

### 5. 開発環境にアクセス

wordpress の構築が終わったら、アクセスしてログイン情報などの設定を行います。  
http://localhost:8080/  

ユーザー登録などが終わったら、作成するテーマを有効にしてください。  

### 6. 必要なパッケージをインストール

```
$ npm install
```


## 開発の覚書

### Sass と JS を更新する

### Sass と JS データ

Sass: `assets/sass/`  
JS: `assets/js/`

#### Sass と JS のコンパイル  

webpackでコンパイル、パッケージングしています。

CSS出力先: `html/wp-content/themes/start-media/style.css`  
JS出力先: `html/wp-content/themes/start-media/js/application.js`

```
$ npm run build
```

#### 保存したら、すぐにコンパイルするように監視する場合  

```
$ npm run watch
```

### 画像
テーマで利用する画像はここに置く想定です   

`html/wp-content/themes/start-media/images`  
