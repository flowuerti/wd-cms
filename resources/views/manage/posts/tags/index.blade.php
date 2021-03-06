@section('page_title', 'Manage Tags')

@extends('layouts.backend')

@section('content')
    <div class="flex-container">
        <div class="columns m-t-10">
            <div class="column">
                <h1 class="title">Manage Tags</h1>
            </div>
        </div>
        <hr class="m-t-0">

        @if (session('status'))
            <div class="notification notification-success is-info">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br/>
        @endif

        <div class="columns">
            <div class="column is-one-third">
                <h2 class="subtitle">Add New Tag</h2>

                <form action="{{route('tags.store')}}" method="post">
                    @csrf
                    <div class="field">
                        <label for="tag_name" class="label">Name</label>
                        <div class="control">
                            <input id="tag_name" name="tag_name" class="input" type="text" placeholder="Tag name">
                        </div>
                    </div>
                    <div class="field">
                        <label for="tag_slug" class="label">Slug</label>
                        <div class="control">
                            <input id="tag_slug" name="tag_slug" class="input" type="text" placeholder="Tag slug"
                                   value="{{ old('tag_slug') }}">
                            @if($errors->first('tag_slug'))
                                <div class="alert alert-danger">
                                    <ul>
                                        <li>{{ $errors->first('tag_slug') }}</li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="field">
                        <label for="tag_description" class="label">Tag Description</label>
                        <div class="control">
                            <textarea id="tag_description" name="tag_description" class="textarea"
                                      placeholder="Tag Description"></textarea>
                        </div>
                    </div>
                    <div class="primary-action-button">
                        <button type="submit" name="add_new_tag" value="add_new_tag" class="button is-primary">Add New
                            Tag
                        </button>
                    </div>
                </form>
            </div>
            <div class="column is-two-thirds">
                <div class="b-table"><!---->
                    <div class="table-wrapper">
                        <table class="table has-mobile-cards">
                            <thead>
                            <tr><!----> <!---->
                                <th class="">
                                    <div class="th-wrap">Name <span class="icon is-small" style="display: none;">
                                    <i class="mdi mdi-arrow-up"></i>
                                </span>
                                    </div>
                                </th>
                                <th class="">
                                    <div class="th-wrap">Description <span class="icon is-small" style="display: none;">
                                    <i class="mdi mdi-arrow-up"></i>
                                </span>
                                    </div>
                                </th>
                                <th class="">
                                    <div class="th-wrap">Slug<span class="icon is-small" style="display: none;">
                                    <i class="mdi mdi-arrow-up"></i>
                                </span>
                                    </div>
                                </th>
                                <th class="">
                                    <div class="th-wrap">Count <span class="icon is-small" style="display: none;">
                                    <i class="mdi mdi-arrow-up"></i>
                                    </span>
                                    </div>
                                </th>
                                <th class="">
                                    <div class="th-wrap">Option
                                        <i class="mdi mdi-arrow-up"></i>
                                    </div>
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($tags as $tag)

                                <tr draggable="false" class=""><!----> <!---->
                                    <td>
                                        <a href="{{route('tags.edit', $tag->id)}}">
                                            <span>{{$tag->name}}</span>
                                        </a>
                                    </td>
                                    <td>
                                        @if($tag->description)
                                            <span>{{$tag->description}}</span>
                                        @else
                                            <span class="has-text-grey-lighter">No description</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span>{{$tag->slug}}</span>
                                    </td>
                                    <td>
                                        <a href="#">
                                            <span>{{$tag->posts->count()}}</span>
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{route('tags.edit', $tag->id)}}" class="">
                                            <i class="fas fa-edit"></i>
                                            <span class="is-hidden">Edit</span>
                                        </a>
                                        <!--<a href="#" @click="showModal"><i class="far fa-trash-alt"></i>
                                            <span class="is-hidden">Delete</span>
                                        </a>-->

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                {{$tags->links('vendor.pagination.default')}}

            </div>
        </div>
    </div>
@endsection