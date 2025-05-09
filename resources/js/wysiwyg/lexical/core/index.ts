/**
 * Copyright (c) Meta Platforms, Inc. and affiliates.
 *
 * This source code is licensed under the MIT license found in the
 * LICENSE file in the root directory of this source tree.
 *
 */

export type {PasteCommandType} from './LexicalCommands';
export type {
  CommandListener,
  CommandListenerPriority,
  CommandPayloadType,
  CreateEditorArgs,
  EditableListener,
  EditorConfig,
  EditorSetOptions,
  EditorThemeClasses,
  EditorThemeClassName,
  EditorUpdateOptions,
  HTMLConfig,
  Klass,
  KlassConstructor,
  LexicalCommand,
  LexicalEditor,
  LexicalNodeReplacement,
  MutationListener,
  NodeMutation,
  SerializedEditor,
  Spread,
  Transform,
} from './LexicalEditor';
export type {
  EditorState,
  EditorStateReadOptions,
  SerializedEditorState,
} from './LexicalEditorState';
export type {
  DOMChildConversion,
  DOMConversion,
  DOMConversionFn,
  DOMConversionMap,
  DOMConversionOutput,
  DOMExportOutput,
  LexicalNode,
  NodeKey,
  NodeMap,
  SerializedLexicalNode,
} from './LexicalNode';
export type {
  BaseSelection,
  NodeSelection,
  Point,
  PointType,
  RangeSelection,
} from './LexicalSelection';
export type {
  SerializedElementNode,
} from './nodes/LexicalElementNode';
export type {SerializedRootNode} from './nodes/LexicalRootNode';
export type {
  SerializedTextNode,
  TextFormatType,
  TextModeType,
} from './nodes/LexicalTextNode';

// TODO Move this somewhere else and/or recheck if we still need this
export {
  BLUR_COMMAND,
  CAN_REDO_COMMAND,
  CAN_UNDO_COMMAND,
  CLEAR_EDITOR_COMMAND,
  CLEAR_HISTORY_COMMAND,
  CLICK_COMMAND,
  CONTROLLED_TEXT_INSERTION_COMMAND,
  COPY_COMMAND,
  createCommand,
  CUT_COMMAND,
  DELETE_CHARACTER_COMMAND,
  DELETE_LINE_COMMAND,
  DELETE_WORD_COMMAND,
  DRAGEND_COMMAND,
  DRAGOVER_COMMAND,
  DRAGSTART_COMMAND,
  DROP_COMMAND,
  FOCUS_COMMAND,
  FORMAT_TEXT_COMMAND,
  INDENT_CONTENT_COMMAND,
  INSERT_LINE_BREAK_COMMAND,
  INSERT_PARAGRAPH_COMMAND,
  INSERT_TAB_COMMAND,
  KEY_ARROW_DOWN_COMMAND,
  KEY_ARROW_LEFT_COMMAND,
  KEY_ARROW_RIGHT_COMMAND,
  KEY_ARROW_UP_COMMAND,
  KEY_BACKSPACE_COMMAND,
  KEY_DELETE_COMMAND,
  KEY_DOWN_COMMAND,
  KEY_ENTER_COMMAND,
  KEY_ESCAPE_COMMAND,
  KEY_MODIFIER_COMMAND,
  KEY_SPACE_COMMAND,
  KEY_TAB_COMMAND,
  MOVE_TO_END,
  MOVE_TO_START,
  OUTDENT_CONTENT_COMMAND,
  PASTE_COMMAND,
  REDO_COMMAND,
  REMOVE_TEXT_COMMAND,
  SELECT_ALL_COMMAND,
  SELECTION_CHANGE_COMMAND,
  SELECTION_INSERT_CLIPBOARD_NODES_COMMAND,
  UNDO_COMMAND,
} from './LexicalCommands';
export {
  IS_ALL_FORMATTING,
  IS_BOLD,
  IS_CODE,
  IS_HIGHLIGHT,
  IS_ITALIC,
  IS_STRIKETHROUGH,
  IS_SUBSCRIPT,
  IS_SUPERSCRIPT,
  IS_UNDERLINE,
  TEXT_TYPE_TO_FORMAT,
} from './LexicalConstants';
export {
  COMMAND_PRIORITY_CRITICAL,
  COMMAND_PRIORITY_EDITOR,
  COMMAND_PRIORITY_HIGH,
  COMMAND_PRIORITY_LOW,
  COMMAND_PRIORITY_NORMAL,
  createEditor,
} from './LexicalEditor';
export type {EventHandler} from './LexicalEvents';
export {$normalizeSelection as $normalizeSelection__EXPERIMENTAL} from './LexicalNormalization';
export {
  $createNodeSelection,
  $createPoint,
  $createRangeSelection,
  $createRangeSelectionFromDom,
  $getCharacterOffsets,
  $getPreviousSelection,
  $getSelection,
  $getTextContent,
  $insertNodes,
  $isBlockElementNode,
  $isNodeSelection,
  $isRangeSelection,
} from './LexicalSelection';
export {$parseSerializedNode, isCurrentlyReadOnlyMode} from './LexicalUpdates';
export {
  $addUpdateTag,
  $applyNodeReplacement,
  $cloneWithProperties,
  $copyNode,
  $getAdjacentNode,
  $getEditor,
  $getNearestNodeFromDOMNode,
  $getNearestRootOrShadowRoot,
  $getNodeByKey,
  $getNodeByKeyOrThrow,
  $getRoot,
  $hasAncestor,
  $hasUpdateTag,
  $isInlineElementOrDecoratorNode,
  $isLeafNode,
  $isRootOrShadowRoot,
  $isTokenOrSegmented,
  $nodesOfType,
  $selectAll,
  $setCompositionKey,
  $setSelection,
  $splitNode,
  getEditorPropertyFromDOMNode,
  getNearestEditorFromDOMNode,
  isBlockDomNode,
  isHTMLAnchorElement,
  isHTMLElement,
  isInlineDomNode,
  isLexicalEditor,
  isSelectionCapturedInDecoratorInput,
  isSelectionWithinEditor,
  resetRandomKey,
} from './LexicalUtils';
export {ArtificialNode__DO_NOT_USE} from './nodes/ArtificialNode';
export {$isDecoratorNode, DecoratorNode} from './nodes/LexicalDecoratorNode';
export {$isElementNode, ElementNode} from './nodes/LexicalElementNode';
export type {SerializedLineBreakNode} from './nodes/LexicalLineBreakNode';
export {
  $createLineBreakNode,
  $isLineBreakNode,
  LineBreakNode,
} from './nodes/LexicalLineBreakNode';
export type {SerializedParagraphNode} from './nodes/LexicalParagraphNode';
export {
  $createParagraphNode,
  $isParagraphNode,
  ParagraphNode,
} from './nodes/LexicalParagraphNode';
export {$isRootNode, RootNode} from './nodes/LexicalRootNode';
export type {SerializedTabNode} from './nodes/LexicalTabNode';
export {$createTabNode, $isTabNode, TabNode} from './nodes/LexicalTabNode';
export {$createTextNode, $isTextNode, TextNode} from './nodes/LexicalTextNode';
