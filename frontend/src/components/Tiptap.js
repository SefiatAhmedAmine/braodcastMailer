import React from 'react'
// src/Tiptap.jsx
import { useEditor, EditorContent } from '@tiptap/react'
import StarterKit from '@tiptap/starter-kit'
import Underline from '@tiptap/extension-underline'
import Image from '@tiptap/extension-image';
import axios from 'axios';
import FormData from 'form-data';

import {
  FaBold, FaItalic, FaStrikethrough, FaListOl, FaListUl,
  FaQuoteLeft, FaRedo, FaUndo, FaRemoveFormat, FaCode, FaUnderline,
  FaLine,
  FaImage
} from 'react-icons/fa';

import './styles.css'

const BACKEND_URL = "http://courrier.back/backend/src/controllers/UploadController.php";
const MenuBar = ({ editor }) => {
  if (!editor) {
    return null
  }

  const uploadImage = (e) => {
    
    const file = e.target.files[0];
    var data = new FormData();
    data.append('file', file);

    axios({
      method: 'post',
      url: BACKEND_URL,
      data: data,
      headers: {'Content-Type': 'multipart/form-data' }
      })
      .then(function (response) {
          //handle success
          let url = response.data.imgURL;
          console.log(url)
          editor.chain().focus().setImage({ src: url }).run()
          // console.log(response);
      })
      .catch(function (response) {
          //handle error
          console.log(response);
      });
  }

  return (
    <div className='menu-bar'>
      <div>
        <button
          onClick={() => editor.chain().focus().toggleBold().run()}
          className={editor.isActive('bold') ? 'is-active' : ''}
        >
          <FaBold />
        </button>
        <button
          onClick={() => editor.chain().focus().toggleItalic().run()}
          className={editor.isActive('italic') ? 'is-active' : ''}
        >
          <FaItalic />
        </button>
        <button
          onClick={() => editor.chain().focus().toggleUnderline().run()}
          className={editor.isActive('underline') ? 'is-active' : ''}
        >
          <FaUnderline />
        </button>
        <button
          onClick={() => editor.chain().focus().toggleStrike().run()}
          className={editor.isActive('strike') ? 'is-active' : ''}
        >
          <FaStrikethrough />
        </button>
        <button
          onClick={() => editor.chain().focus().toggleCode().run()}
          className={editor.isActive('code') ? 'is-active' : ''}
        >
          <FaCode />
        </button>
        <button onClick={() => editor.chain().focus().unsetAllMarks().run()}>
          <FaRemoveFormat />
        </button>
        {/* <button onClick={() => editor.chain().focus().clearNodes().run()}>
        clear nodes
        </button>
        <button
          onClick={() => editor.chain().focus().setParagraph().run()}
          className={editor.isActive('paragraph') ? 'is-active' : ''}
        >
          paragraph
        </button> */}
        <button
          onClick={() => editor.chain().focus().toggleHeading({ level: 1 }).run()}
          className={editor.isActive('heading', { level: 1 }) ? 'is-active' : ''}
        >
          h1
        </button>
        <button
          onClick={() => editor.chain().focus().toggleHeading({ level: 2 }).run()}
          className={editor.isActive('heading', { level: 2 }) ? 'is-active' : ''}
        >
          h2
        </button>
        <button
          onClick={() => editor.chain().focus().toggleHeading({ level: 3 }).run()}
          className={editor.isActive('heading', { level: 3 }) ? 'is-active' : ''}
        >
          h3
        </button>
        <button
          onClick={() => editor.chain().focus().toggleHeading({ level: 4 }).run()}
          className={editor.isActive('heading', { level: 4 }) ? 'is-active' : ''}
        >
          h4
        </button>
        <button
          onClick={() => editor.chain().focus().toggleHeading({ level: 5 }).run()}
          className={editor.isActive('heading', { level: 5 }) ? 'is-active' : ''}
        >
          h5
        </button>
        <button
          onClick={() => editor.chain().focus().toggleHeading({ level: 6 }).run()}
          className={editor.isActive('heading', { level: 6 }) ? 'is-active' : ''}
        >
          h6
        </button>
        <button
          onClick={() => editor.chain().focus().toggleBulletList().run()}
          className={editor.isActive('bulletList') ? 'is-active' : ''}
        >
          <FaListUl />
        </button>
        <button
          onClick={() => editor.chain().focus().toggleOrderedList().run()}
          className={editor.isActive('orderedList') ? 'is-active' : ''}
        >
          <FaListOl />
        </button>
        {/* <button
        onClick={() => editor.chain().focus().toggleCodeBlock().run()}
        className={editor.isActive('codeBlock') ? 'is-active' : ''}
        >
          <FaCode/>
        </button> */}
        <button
          onClick={() => editor.chain().focus().toggleBlockquote().run()}
          className={editor.isActive('blockquote') ? 'is-active' : ''}
        >
          <FaQuoteLeft />
        </button>
        <button onClick={() => editor.chain().focus().setHorizontalRule().run()}>
          <FaLine />
        </button>
        <label htmlFor="image" className='image'><FaImage /></label>
        <input type="file" name="image" accept="image/*" id="image" hidden onChange={uploadImage} />

      </div>
      {/* <button onClick={() => editor.chain().focus().setHardBreak().run()}>
        hard break
      </button> */}
      <div style={{ width: 'fit-content', display: 'flex' }}>
        <button onClick={() => editor.chain().focus().undo().run()}>
          <FaUndo />
        </button>
        <button onClick={() => editor.chain().focus().redo().run()}>
          <FaRedo />
        </button>
      </div>
    </div>
  )
}

const Tiptap = ({ setContent }) => {
  const editor = useEditor({
    extensions: [
      StarterKit,
      Underline,
      Image,
    ],
    content: ``,
    onUpdate: ({ editor }) => {
      setContent(editor.getHTML());
    }
  })

  return (
    <div className='text-editor'>
      <MenuBar editor={editor} />
      <EditorContent editor={editor} />
    </div>
  )
}


export default Tiptap;