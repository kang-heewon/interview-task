<form action="/books/{{$book->id}}" method="POST">
  @csrf
  @method('PUT')
  <input type="text" name="name" value="{{$book->name}}" />
  <input type="text" name="price" value="{{$book->price}}" />
  <input type="text" name="category" value="{{$book->category->category}}" />
  <button type="submit">yeahhhh</button>
</form>

<form action="/books/{{$book->id}}" method="POST">
  @csrf
  @method('DELETE')
  <button type="submit"> 디스 이즈 삭제 오키?</button>
</form>