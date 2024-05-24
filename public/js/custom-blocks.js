// public/js/custom-blocks.js

wp.blocks.registerBlockType('custom/alert-box', {
    title: 'Alert Box',
    icon: 'warning',
    category: 'common',
    attributes: {
        content: {
            type: 'string',
            source: 'html',
            selector: 'div',
        },
        alertType: {
            type: 'string',
            default: 'info',
        },
    },
    edit: (props) => {
        const { attributes: { content, alertType }, setAttributes, className } = props;

        const onChangeContent = (newContent) => {
            setAttributes({ content: newContent });
        };

        const onChangeAlertType = (newType) => {
            setAttributes({ alertType: newType });
        };

        return (
            <div className={className}>
                <select value={alertType} onChange={(event) => onChangeAlertType(event.target.value)}>
                    <option value="info">Info</option>
                    <option value="warning">Warning</option>
                    <option value="error">Error</option>
                </select>
                <wp.editor.RichText
                    tagName="div"
                    className={`alert-box alert-${alertType}`}
                    value={content}
                    onChange={onChangeContent}
                    placeholder="Write your alert message..."
                />
            </div>
        );
    },
    save: (props) => {
        const { attributes: { content, alertType } } = props;

        return (
            <div className={`alert-box alert-${alertType}`}>
                <wp.editor.RichText.Content value={content} />
            </div>
        );
    },
});

wp.blocks.registerBlockType('custom/quote-box', {
    title: 'Quote Box',
    icon: 'format-quote',
    category: 'common',
    attributes: {
        content: {
            type: 'string',
            source: 'html',
            selector: 'blockquote',
        },
        author: {
            type: 'string',
            source: 'text',
            selector: 'cite',
        },
    },
    edit: (props) => {
        const { attributes: { content, author }, setAttributes, className } = props;

        const onChangeContent = (newContent) => {
            setAttributes({ content: newContent });
        };

        const onChangeAuthor = (newAuthor) => {
            setAttributes({ author: newAuthor });
        };

        return (
            <blockquote className={className}>
                <wp.editor.RichText
                    tagName="p"
                    value={content}
                    onChange={onChangeContent}
                    placeholder="Write your quote..."
                />
                <wp.editor.RichText
                    tagName="cite"
                    value={author}
                    onChange={onChangeAuthor}
                    placeholder="Author name"
                />
            </blockquote>
        );
    },
    save: (props) => {
        const { attributes: { content, author } } = props;

        return (
            <blockquote>
                <wp.editor.RichText.Content tagName="p" value={content} />
                <cite>{author}</cite>
            </blockquote>
        );
    },
});
