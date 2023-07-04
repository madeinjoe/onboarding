<?php

namespace Custom\Input;

defined('ABSPATH') || die("Direct access not allowed");

class CustomInput
{
    public function renderInput(array $attrib = [])
    {
        if (!$attrib or count($attrib) <= 0) {
            return;
        } else {
            echo '<div style="display: flex; flex-direction: column; flex-wrap: nowrap; align-items: start; gap: 0.5rem;">';
            echo '<label style="display; block; font-weight: bold; color: rgba(0, 0, 0, 1);" for="ci' . $attrib['meta-key'] . '">' . $attrib['label'] . '</label>';
            switch ($attrib['type']) {
                case 'number':
                    echo '<input style="width: 100%; border-width: 1px; border-color: rgba(209, 213, 219, 1); padding: 0.375rem 0.5rem; font-size: 1rem; line-height: 1.5rem; font-weight: 400;" type="number" id="ci_' . $attrib['meta-key'] . '" name="' . $attrib['meta-key'] . '" min="' . ($attrib['min'] ?? 0) . '" max="' . ($attrib['max'] ?? 100) . '" step="' . ($attrib['step'] ?? '0.01') . '" value="' . ($attrib['meta-value'] ?? '') . '" />';
                    break;
                case 'text-area':
                    echo '<textarea style="width: 100%; border-width: 1px; border-color: rgba(209, 213, 219, 1); padding: 0.375rem 0.5rem; font-size: 1rem; line-height: 1.5rem; font-weight: 400;" id="ci_' . $attrib['meta-key'] . '" name="' . $attrib['meta-key'] . '" rows="4">' . $attrib['meta-value'] . '</textarea>';
                    break;
                default:
                    echo '<input style="width: 100%; border-width: 1px; border-color: rgba(209, 213, 219, 1); padding: 0.375rem 0.5rem; font-size: 1rem; line-height: 1.5rem; font-weight: 400;" type="text" id="ci_' . $attrib['meta-key'] . '" name="' . $attrib['meta-key'] . '" placeholder="' . ($attrib['placeholder'] ?? 'Please insert your input...') . '" value="' . $attrib['meta-value'] . '"></input>';
            }
            echo '</div>';
        }
    }

    public function renderAllInput(array $metas = [], Bool $with_nonce = false, $nonce_action = -1, $nonce_name = "_custom_mb")
    {
        if (!$metas or count($metas) <= 0) {
            return;
        } else {
            echo '<div style="display: flex; flex-direction: column; gap: 0.5rem;">';
            if ($with_nonce) {
                wp_nonce_field($nonce_action, $nonce_name . "_nonce");
            }

            foreach ($metas as $attrib) {
                echo '<div style="display: flex; flex-direction: column; flex-wrap: nowrap; align-items: start; gap: 0.5rem;">';
                echo '<label style="display; block; font-weight: bold; color: rgba(0, 0, 0, 1);" for="ci' . $attrib['meta-key'] . '">' . $attrib['label'] . (isset($attrib['required']) && $attrib['required'] ? '&nbsp<small style="color: red;">*</small>' : '') . '</label>';
                switch ($attrib['type']) {
                    case 'number':
                        echo '<input style="width: 100%; border-width: 1px; border-color: rgba(209, 213, 219, 1); padding: 0.375rem 0.5rem; font-size: 1rem; line-height: 1.5rem; font-weight: 400;" type="number" id="ci_' . $attrib['meta-key'] . '" name="' . $attrib['meta-key'] . '" min="' . ($attrib['min'] ?? 0) . '" max="' . ($attrib['max'] ?? 100) . '" step="' . ($attrib['step'] ?? '0.01') . '" placeholder="' . ($attrib['placeholder'] ?? 'Please insert your input...') . '" value="' . ($attrib['meta-value'] ?? '') . '"  ' . (isset($attrib['required']) && $attrib['required'] ? 'required="required"' : '') . '/>';
                        break;
                    case 'textarea':
                        echo '<textarea style="width: 100%; border-width: 1px; border-color: rgba(209, 213, 219, 1); padding: 0.375rem 0.5rem; font-size: 1rem; line-height: 1.5rem; font-weight: 400;" id="ci_' . $attrib['meta-key'] . '" name="' . $attrib['meta-key'] . '" rows="4" placeholder="' . ($attrib['placeholder'] ?? 'Please insert your input...') . '" ' . (isset($attrib['required']) && $attrib['required'] ? 'required="required"' : '') . '>' . $attrib['meta-value'] . '</textarea>';
                        break;
                    case 'select':
                        echo '<select style="width: 100%; border-width: 1px; border-color: rgba(209, 213, 219, 1); padding: 0.375rem 0.5rem; font-size: 1rem; line-height: 1.5rem; font-weight: 400;" type="number" id="ci_' . $attrib['meta-key'] . '" name="' . $attrib['meta-key'] . '" ' . (isset($attrib['required']) && $attrib['required'] ? 'required="required"' : '') . '>';
                        echo '<option value="">' . ($attrib['placeholder'] ?? 'Please choose option') . '</option>';
                        foreach ($attrib['options'] as $key => $value) {
                            echo '<option value="' . $key . '" ' . ($attrib['meta-value'] == $key ? 'selected="selected"' : '') . '>' . $value . '</option>';
                        }
                        echo '</select>';
                        break;
                    default:
                        echo '<input style="width: 100%; border-width: 1px; border-color: rgba(209, 213, 219, 1); padding: 0.375rem 0.5rem; font-size: 1rem; line-height: 1.5rem; font-weight: 400;" type="text" id="ci_' . $attrib['meta-key'] . '" name="' . $attrib['meta-key'] . '" placeholder="' . ($attrib['placeholder'] ?? 'Please insert your input...') . '" value="' . $attrib['meta-value'] . '" ' . (isset($attrib['required']) && $attrib['required'] ? 'required="required"' : '') . ' />';
                }
                echo '</div>';
            }
            echo '</div>';
        }
    }
}
