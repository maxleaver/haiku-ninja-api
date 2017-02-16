# Haiku Ninja Backend API

Backend API for retrieving haiku from social media comments.

## Installation

Clone or download the git repository to your local development environment, then run
```bash
php composer.phar install
```

## Configuration
1. Rename the `.env.example` to `.env`.
2. Add your app name, Google API key and a secret key to the `.env` file, add your app name.
5. Point your web server to the public directory.

## Usage

Currently, the API only has one route:

```GET https://example.com/comments```

The route accepts the following parameters:

**id**
A YouTube video ID

**nextPageToken**
Optional token from the YouTube API. One is provided in the response if your YouTube video has more than 100 comments.

**type**
The social media site to access (currently only accepts 'youtube').

## License

This application is licensed under The MIT License (MIT). See the LICENSE file for more details.