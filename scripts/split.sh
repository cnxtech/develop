#!/usr/bin/env bash

MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )
CURRENT_BRANCH="develop"

function split()
{
    SHA1=`${MYDIR}/splitsh-lite --prefix=$1`
    git push $2 "$SHA1:refs/heads/$CURRENT_BRANCH" -f
}

function configure(){
    # https://stackoverflow.com/a/51333607/2643122
    git config --local --add remote.$1.fetch +refs/tags/*:refs/tags/$1/*
    git config remote.$1.tagopt --no-tags
}

function remote(){
    local PREFIX=bitbucket.org:codex-project
    git remote add $1 "${PREFIX}/$1" || true
#    configure $1
}

git pull origin $CURRENT_BRANCH

configure origin

remote algolia-search
remote auth
remote blog
remote comments
remote composer-plugin
remote core
remote filesystems
remote git
remote packagist
remote phpdoc
remote sitemap

split 'codex/algolia-search' algolia-search
split 'codex/auth' auth
split 'codex/blog' blog
split 'codex/comments' comments
split 'codex/composer-plugin' composer-plugin
split 'codex/core' core
split 'codex/filesystems' filesystems
split 'codex/git' git
split 'codex/packagist' packagist
split 'codex/phpdoc' phpdoc
split 'codex/sitemap' sitemap

